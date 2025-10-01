<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Variety;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VarietyController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_varietas_tebu')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Variety::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_varietas_tebu) {
                        $editUrl = route('varieties.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_varietas_tebu) {
                        $deleteUrl = route('varieties.destroy', $row->id);
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

        return view('varieties.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_varietas_tebu')) {
            return $response;
        }

        return view('varieties.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_varietas_tebu')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        Variety::create($request->all());

        ActivityLog::log(Auth()->user()->id, "Membuat varietas tebu {$request->name}.");

        return redirect()->route('varieties.index')->with('success', 'Varietas Tebu berhasil ditambahkan.');
    }

    public function edit(Variety $variety)
    {
        if ($response = $this->checkIzin('akses_edit_varietas_tebu')) {
            return $response;
        }

        return view('varieties.edit', compact('variety'));
    }

    public function update(Request $request, Variety $variety)
    {
        if ($response = $this->checkIzin('akses_edit_varietas_tebu')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        ActivityLog::log(Auth()->user()->id, "Ganti varietas tebu {$variety->name} ke {$request->name}.");

        $variety->update($request->all());

        return redirect()->route('varieties.index')->with('success', 'Varietas Tebu berhasil diperbarui.');
    }

    public function destroy(Variety $variety)
    {
        if ($response = $this->checkIzin('akses_hapus_varietas_tebu')) {
            return $response;
        }

        ActivityLog::log(Auth()->user()->id, "Hapus varietas tebu {$variety->name}.");

        $variety->delete();

        return redirect()->route('varieties.index')->with('success', 'Varietas Tebu berhasil dihapus.');
    }
}
