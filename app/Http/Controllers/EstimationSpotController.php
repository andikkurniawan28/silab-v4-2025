<?php

namespace App\Http\Controllers;

use App\Models\EstimationSpot;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EstimationSpotController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_titik_taksasi')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = EstimationSpot::with('unit');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('unit', function ($row) {
                    return $row->unit ? $row->unit->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_titik_taksasi) {
                        $editUrl = route('estimation_spots.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_titik_taksasi) {
                        $deleteUrl = route('estimation_spots.destroy', $row->id);
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

        return view('estimation_spots.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_titik_taksasi')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');
        return view('estimation_spots.create', compact('units'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_titik_taksasi')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        EstimationSpot::create($request->all());

        return redirect()->route('estimation_spots.index')->with('success', 'Titik Taksasi berhasil ditambahkan.');
    }

    public function edit(EstimationSpot $estimation_spot)
    {
        if ($response = $this->checkIzin('akses_edit_titik_taksasi')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');
        return view('estimation_spots.edit', compact('estimation_spot', 'units'));
    }

    public function update(Request $request, EstimationSpot $estimation_spot)
    {
        if ($response = $this->checkIzin('akses_edit_titik_taksasi')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        $estimation_spot->update($request->all());

        return redirect()->route('estimation_spots.index')->with('success', 'Titik Taksasi berhasil diperbarui.');
    }

    public function destroy(EstimationSpot $estimation_spot)
    {
        if ($response = $this->checkIzin('akses_hapus_titik_taksasi')) {
            return $response;
        }

        $estimation_spot->delete();
        return redirect()->route('estimation_spots.index')->with('success', 'Titik Taksasi berhasil dihapus.');
    }
}
