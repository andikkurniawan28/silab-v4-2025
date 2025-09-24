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
        $station = Station::findOrFail($station_id);
        return view('results.perstation', compact('station'));
    }

    public function perStationData($station_id)
    {
        $station = DB::table('stations')->find($station_id);

        $materials = DB::table('materials')
            ->where('station_id', $station_id)
            ->get();

        $result = [
            'station' => $station->name,
            'materials' => []
        ];

        foreach ($materials as $material) {
            $parameters = DB::table('parameter_materials')
                ->join('parameters', 'parameter_materials.parameter_id', '=', 'parameters.id')
                ->where('parameter_materials.material_id', $material->id)
                ->select('parameters.id', 'parameters.name')
                ->get();

            $parameterColumns = $parameters->map(fn($p) => "analyses.p{$p->id}")->toArray();

            $baseColumns = [
                'analyses.id',
                'analyses.created_at',
            ];

            $selects = array_merge($baseColumns, $parameterColumns);

            $analyses = DB::table('analyses')
                ->where('material_id', $material->id)
                ->where('is_verified', 1)
                ->orderByDesc('id')
                ->limit(5)
                ->select($selects)
                ->get();

            $result['materials'][] = [
                'id' => $material->id,
                'material' => $material->name,
                'parameters' => $parameters->map(fn($p) => [
                    'field' => "p{$p->id}",
                    'name'  => $p->name,
                ]),
                'analyses' => $analyses
            ];
        }

        return $result;
    }

    public function perMaterial($material_id)
    {
        $material = Material::with('parameters')->findOrFail($material_id);
        return view('results.permaterial', compact('material'));
    }

    public function perMaterialData(Request $request, $material_id)
    {
        $material = Material::with('parameters')->findOrFail($material_id);

        // tentukan kolom dasar
        $baseCols = ['id', 'created_at'];

        // tentukan kolom parameter sesuai material
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
