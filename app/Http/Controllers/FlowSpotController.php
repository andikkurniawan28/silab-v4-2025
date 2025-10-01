<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\FlowSpot;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FlowSpotController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_titik_flow')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = FlowSpot::with('unit');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('unit', function ($row) {
                    return $row->unit ? $row->unit->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_titik_flow) {
                        $editUrl = route('flow_spots.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_titik_flow) {
                        $deleteUrl = route('flow_spots.destroy', $row->id);
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

        return view('flow_spots.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_titik_flow')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');
        return view('flow_spots.create', compact('units'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_titik_flow')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        ActivityLog::log(Auth()->user()->id, "Membuat titik flow {$request->name}.");

        FlowSpot::create($request->all());

        return redirect()->route('flow_spots.index')->with('success', 'Titik Flow berhasil ditambahkan.');
    }

    public function edit(FlowSpot $flow_spot)
    {
        if ($response = $this->checkIzin('akses_edit_titik_flow')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');

        return view('flow_spots.edit', compact('flow_spot', 'units'));
    }

    public function update(Request $request, FlowSpot $flow_spot)
    {
        if ($response = $this->checkIzin('akses_edit_titik_flow')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        ActivityLog::log(Auth()->user()->id, "Ganti titik flow {$flow_spot->name} ke {$request->name}.");

        $flow_spot->update($request->all());

        return redirect()->route('flow_spots.index')->with('success', 'Titik Flow berhasil diperbarui.');
    }

    public function destroy(FlowSpot $flow_spot)
    {
        if ($response = $this->checkIzin('akses_hapus_titik_flow')) {
            return $response;
        }

        ActivityLog::log(Auth()->user()->id, "Hapus titik flow {$flow_spot->name}.");

        $flow_spot->delete();

        return redirect()->route('flow_spots.index')->with('success', 'Titik Flow berhasil dihapus.');
    }
}
