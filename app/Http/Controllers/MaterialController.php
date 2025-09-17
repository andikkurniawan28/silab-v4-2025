<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Material;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_material')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Material::with('station');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('station', function ($row) {
                    return $row->station->name ?? '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_material ?? false) {
                        $editUrl = route('materials.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_material ?? false) {
                        $deleteUrl = route('materials.destroy', $row->id);
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
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('materials.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_material')) {
            return $response;
        }

        $stations = Station::pluck('name', 'id');
        $parameters = Parameter::all();

        return view('materials.create', compact('stations', 'parameters'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_material')) {
            return $response;
        }

        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'name'       => 'required|string|max:255',
            'is_active'  => 'nullable|boolean',
            'parameters' => 'array',
            'parameters.*' => 'exists:parameters,id',
        ]);

        $material = Material::create([
            'station_id' => $request->station_id,
            'name'       => $request->name,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        // simpan parameter ke pivot
        if ($request->has('parameters')) {
            $material->parameters()->sync($request->parameters);
        }

        return redirect()->route('materials.index')->with('success', 'Material berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        if ($response = $this->checkIzin('akses_edit_material')) {
            return $response;
        }

        $stations = Station::pluck('name', 'id');
        $parameters = Parameter::all();
        $selected   = $material->parameters->pluck('id')->toArray();

        return view('materials.edit', compact('material', 'stations', 'parameters', 'selected'));
    }

    public function update(Request $request, Material $material)
    {
        if ($response = $this->checkIzin('akses_edit_material')) {
            return $response;
        }

        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'name'       => 'required|string|max:255',
            'is_active'  => 'nullable|boolean',
            'parameters' => 'array',
            'parameters.*' => 'exists:parameters,id',
        ]);

        $material->update([
            'station_id' => $request->station_id,
            'name'       => $request->name,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        $material->parameters()->sync($request->parameters ?? []);

        return redirect()->route('materials.index')->with('success', 'Material berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        if ($response = $this->checkIzin('akses_hapus_material')) {
            return $response;
        }

        $material->parameters()->detach();
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material berhasil dihapus.');
    }
}
