<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\MonitoringHourlySpot;

class MonitoringHourlySpotController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_titik_monitoring_perjam')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = MonitoringHourlySpot::with('unit');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('unit', function ($row) {
                    return $row->unit ? $row->unit->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_titik_monitoring_perjam) {
                        $editUrl = route('monitoring_hourly_spots.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_titik_monitoring_perjam) {
                        $deleteUrl = route('monitoring_hourly_spots.destroy', $row->id);
                        $buttons .= '
                            <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Hapus data ini?\')" style="display:inline-block;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        ';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('monitoring_hourly_spots.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_titik_monitoring_perjam')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');

        return view('monitoring_hourly_spots.create', compact('units'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_titik_monitoring_perjam')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        MonitoringHourlySpot::create($request->all());

        ActivityLog::log(Auth()->user()->id, "Membuat titik monitoring perjam {$request->name}.");

        return redirect()->route('monitoring_hourly_spots.index')->with('success', 'Titik Monitoring Perjam berhasil ditambahkan.');
    }

    public function edit(MonitoringHourlySpot $monitoring_hourly_spot)
    {
        if ($response = $this->checkIzin('akses_edit_titik_monitoring_perjam')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');

        return view('monitoring_hourly_spots.edit', compact('monitoring_hourly_spot', 'units'));
    }

    public function update(Request $request, MonitoringHourlySpot $monitoring_hourly_spot)
    {
        if ($response = $this->checkIzin('akses_edit_titik_monitoring_perjam')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        ActivityLog::log(Auth()->user()->id, "Ganti titik monitoring perjam {$monitoring_hourly_spot->name} ke {$request->name}.");

        $monitoring_hourly_spot->update($request->all());

        return redirect()->route('monitoring_hourly_spots.index')->with('success', 'Titik Monitoring Perjam berhasil diperbarui.');
    }

    public function destroy(MonitoringHourlySpot $monitoring_hourly_spot)
    {
        if ($response = $this->checkIzin('akses_hapus_titik_monitoring_perjam')) {
            return $response;
        }

        ActivityLog::log(Auth()->user()->id, "Hapus titik monitoring perjam {$monitoring_hourly_spot->name}.");

        $monitoring_hourly_spot->delete();

        return redirect()->route('monitoring_hourly_spots.index')->with('success', 'Titik Monitoring Perjam berhasil dihapus.');
    }
}
