<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function analysis(){
        return view('reports.analysis.index');
    }

    public function process(){
        return view('reports.process.index');
    }

    public function posbrix(){
        return view('reports.posbrix.index');
    }

    public function coreSample(){
        return view('reports.coreSample.index');
    }

    public function ariTimbangan(){
        return view('reports.ariTimbangan.index');
    }

    public function penilaianMbs(){
        return view('reports.penilaianMbs.index');
    }

    public function analysisData($date, $shift)
    {
        [$start, $end] = $this->determineShift($date, $shift);

        // Ambil semua material
        $materials = DB::table('materials')
            ->pluck('name', 'id');

        $materialIds = $materials->keys()->toArray();

        // Ambil semua parameter yang terkait material
        $parameterRows = DB::table('parameter_materials')
            ->join('parameters', 'parameter_materials.parameter_id', '=', 'parameters.id')
            ->whereIn('parameter_materials.material_id', $materialIds)
            ->select('parameters.id', 'parameters.name')
            ->distinct()
            ->orderBy('parameters.id')
            ->get();

        $paramIds = $parameterRows->pluck('id')->toArray();

        $columns = [];
        $columns[] = ['field' => 'material', 'title' => 'Material'];
        $columns[] = ['field' => 'jumlah', 'title' => 'Qty'];

        foreach ($parameterRows as $p) {
            $columns[] = [
                'field' => 'p' . $p->id,
                'title' => $p->name,
            ];
        }

        $avgSelects = [];
        foreach ($paramIds as $pid) {
            $avgSelects[] = DB::raw("AVG(p{$pid}) as p{$pid}");
        }
        $avgSelects[] = DB::raw("COUNT(*) as jumlah");

        $rows = [];
        foreach ($materialIds as $mid) {
            $avgRow = DB::table('analyses')
                ->whereBetween('created_at', [$start, $end])
                ->where('is_verified', 1)
                ->where('material_id', $mid)
                ->select($avgSelects)
                ->first();

            $row = [
                'material' => $materials[$mid] ?? null,
                'jumlah'   => $avgRow->jumlah ?? 0,
            ];

            foreach ($paramIds as $pid) {
                $field = 'p' . $pid;
                $val = null;
                if ($avgRow && isset($avgRow->{$field})) {
                    $val = is_null($avgRow->{$field}) ? null : round((float)$avgRow->{$field}, 4);
                }
                $row[$field] = $val;
            }

            $rows[] = $row;
        }

        return response()->json([
            'columns' => $columns,
            'rows'    => $rows
        ]);
    }

    public function processData($date, $shift)
    {
        [$start, $end] = $this->determineShift($date, $shift);

        // Ambil semua flow spot
        $flowSpots = DB::table('flow_spots')
            ->where('id', '>', 1)
            ->orderBy('id')
            ->pluck('name', 'id');

        $selects = [
            DB::raw('SUM(flows.sugar_cane) as Tebu_Tergiling')
        ];

        // Tambahkan SUM tiap flow spot
        foreach ($flowSpots as $id => $name) {
            $col = 'f' . $id;
            $alias = "Flow_" . str_replace(' ', '_', ucwords($name));
            $selects[] = DB::raw("SUM(flows.`$col`) as `$alias`");
        }

        // Tambahkan imbibition
        $selects[] = DB::raw("(SELECT SUM(imb.f1)
                            FROM imbibitions imb
                            WHERE imb.created_at BETWEEN '{$start}' AND '{$end}')
                            as Flow_imbibition");

        // Ambil semua monitoring_hourly_spots (AVG)
        $pSpots = DB::table('monitoring_hourly_spots')->orderBy('id')
            ->pluck('name', 'id'); // Asumsi name = pX

        foreach ($pSpots as $id => $name) {
            $col = 'p' . $id;
            $alias = str_replace(' ', '_', ucwords($name));

            $selects[] = DB::raw("(SELECT AVG(mh.`$col`)
                                FROM monitoring_hourlies mh
                                WHERE mh.created_at BETWEEN '{$start}' AND '{$end}')
                                as `$alias`");
        }

        // Ambil semua monitoring_shiftly_spots (SUM)
        $shiftlySpots = DB::table('monitoring_shiftly_spots')->orderBy('id')
            ->pluck('name', 'id'); // Asumsi name = pX

        foreach ($shiftlySpots as $id => $name) {
            $col = 'p' . $id;
            $alias = str_replace(' ', '_', ucwords($name));

            $selects[] = DB::raw("(SELECT SUM(msl.`$col`)
                                FROM monitoring_shiftlies msl
                                WHERE msl.date = '{$date}'" .
                                ($shift !== 'harian' ? " AND msl.shift = '{$shift}'" : "") .
                                ")
                                as `$alias`");
        }

        // Ambil hasil
        $result = DB::table('flows')
            ->whereBetween('flows.created_at', [$start, $end])
            ->select($selects)
            ->first();

        return $result;
    }

    public function posbrixData($date, $shift)
    {
        [$start, $end] = $this->determineShift($date, $shift);

        $data = DB::table('analisa_on_farms as aof')
            ->join('varieties', 'aof.variety_id', '=', 'varieties.id')
            ->join('kawalans', 'aof.kawalan_id', '=', 'kawalans.id')
            ->whereBetween('aof.created_at', [$start, $end])
            ->select(
                'aof.id',
                'aof.spta',
                'aof.brix_posbrix',
                'varieties.name as variety_name',
                'kawalans.name as kawalan_name',
                'aof.status',
                'aof.created_at',
            )
            ->get();

        return response()->json($data);
    }

    public function coreSampleData($date, $shift)
    {
        [$start, $end] = $this->determineShift($date, $shift);

        $data = DB::table('analisa_on_farms as aof')
            ->whereBetween('aof.core_at', [$start, $end])
            ->select(
                'aof.id',
                'aof.nomor_antrian',
                'aof.register',
                'aof.brix_core',
                'aof.pol_core',
                'aof.rendemen_core',
                'aof.core_at',
            )
            ->get();

        return response()->json($data);
    }

    public function ariTimbanganData($date, $shift)
    {
        [$start, $end] = $this->determineShift($date, $shift);

        $data = DB::table('analisa_on_farms as aof')
            ->whereBetween('aof.ari_at', [$start, $end])
            ->select(
                'aof.id',
                'aof.nomor_antrian',
                'aof.register',
                'aof.brix_ari',
                'aof.pol_ari',
                'aof.rendemen_ari',
                'aof.ari_at',
            )
            ->get();

        return response()->json($data);
    }

    private function determineShift($date, $shift){
        switch (strtolower($shift)) {
            case 'harian':
                $start = "{$date} 06:00:00";
                $end   = date('Y-m-d 05:59:59', strtotime("{$date} +1 day"));
                break;

            case 'pagi':
                $start = "{$date} 05:00:00";
                $end   = "{$date} 12:49:59";
                break;

            case 'sore':
                $start = "{$date} 13:00:00";
                $end   = "{$date} 20:59:59";
                break;

            case 'malam':
                $start = "{$date} 21:00:00";
                $end   = date('Y-m-d 04:59:59', strtotime("{$date} +1 day"));
                break;

            default:
                throw new \InvalidArgumentException("Shift '{$shift}' tidak valid");
        }

        return [$start, $end];
    }

}
