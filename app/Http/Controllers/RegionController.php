<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Region;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_wilayah')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Region::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_wilayah) {
                        $editUrl = route('regions.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_wilayah) {
                        $deleteUrl = route('regions.destroy', $row->id);
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

        return view('regions.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_wilayah')) {
            return $response;
        }

        return view('regions.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_wilayah')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        Region::create($request->all());

        ActivityLog::log(Auth()->user()->id, "Membuat wilayah {$request->name}.");

        return redirect()->route('regions.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(Region $region)
    {
        if ($response = $this->checkIzin('akses_edit_wilayah')) {
            return $response;
        }

        return view('regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        if ($response = $this->checkIzin('akses_edit_wilayah')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        ActivityLog::log(Auth()->user()->id, "Ganti wilayah {$region->name} ke {$request->name}.");

        $region->update($request->all());

        return redirect()->route('regions.index')->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroy(Region $region)
    {
        if ($response = $this->checkIzin('akses_hapus_wilayah')) {
            return $response;
        }

        ActivityLog::log(Auth()->user()->id, "Hapus wilayah {$region->name}.");

        $region->delete();

        return redirect()->route('regions.index')->with('success', 'Wilayah berhasil dihapus.');
    }
}
