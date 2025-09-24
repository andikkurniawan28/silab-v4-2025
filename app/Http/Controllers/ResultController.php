<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Analysis;
use App\Models\Material;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function perStation($station_id)
    {
        if ($response = $this->checkIzin('akses_hasil_analisa_per_stasiun')) {
            return $response;
        }

        $station = Station::findOrFail($station_id);
        return view('results.perstation', compact('station'));
    }

    public function perStationData($station_id)
    {
        $station = DB::table('stations')->find($station_id);

        // Ambil semua material + parameter sekaligus
        $materials = DB::table('materials')
            ->where('station_id', $station_id)
            ->get();

        $materialIds = $materials->pluck('id');

        // Ambil parameter untuk semua material sekali jalan
        $parameters = DB::table('parameter_materials')
            ->join('parameters', 'parameter_materials.parameter_id', '=', 'parameters.id')
            ->whereIn('parameter_materials.material_id', $materialIds)
            ->select('parameter_materials.material_id', 'parameters.id', 'parameters.name')
            ->get()
            ->groupBy('material_id');

        // Ambil analyses sekali query, lalu groupBy material
        $analyses = DB::table('analyses')
            ->whereIn('material_id', $materialIds)
            ->where('is_verified', 1)
            ->orderByDesc('id')
            ->get()
            ->groupBy('material_id')
            ->map(fn($rows) => $rows->take(5));

        $result = [
            'station' => $station->name,
            'materials' => $materials->map(function ($m) use ($parameters, $analyses) {
                return [
                    'id' => $m->id,
                    'material' => $m->name,
                    'parameters' => ($parameters[$m->id] ?? collect())->map(fn($p) => [
                        'field' => "p{$p->id}",
                        'name'  => $p->name,
                    ]),
                    'analyses' => $analyses[$m->id] ?? collect(),
                ];
            })->values()
        ];

        return $result;
    }


    public function perMaterial($material_id)
    {
        if ($response = $this->checkIzin('akses_hasil_analisa_per_material')) {
            return $response;
        }
        $material = Material::with('parameters')->findOrFail($material_id);
        return view('results.permaterial', compact('material'));
    }

    public function perMaterialData(Request $request, $material_id)
    {
        $material = Material::with('parameters')->findOrFail($material_id);

        $baseCols = ['id', 'created_at'];

        $paramCols = $material->parameters->map(fn($p) => "p{$p->id}")->toArray();

        $selects = array_merge($baseCols, $paramCols);

        $data = Analysis::where('material_id', $material->id)
            ->where('is_verified', 1)
            ->select($selects)
            ->orderByDesc('id');

        return DataTables::of($data)
            ->editColumn('created_at', function ($row) {
                return $row->created_at
                    ? $row->created_at->format('d-m-Y H:i')
                    : '-';
            })
            ->make(true);
    }
}
