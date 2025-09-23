<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kawalan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KawalanController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_kawalan_tebu')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Kawalan::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_kawalan_tebu) {
                        $editUrl = route('kawalans.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_kawalan_tebu) {
                        $deleteUrl = route('kawalans.destroy', $row->id);
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

        return view('kawalans.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_kawalan_tebu')) {
            return $response;
        }

        return view('kawalans.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_kawalan_tebu')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        Kawalan::create($request->all());

        return redirect()->route('kawalans.index')->with('success', 'Kawalan Tebu berhasil ditambahkan.');
    }

    public function edit(Kawalan $kawalan)
    {
        if ($response = $this->checkIzin('akses_edit_kawalan_tebu')) {
            return $response;
        }

        return view('kawalans.edit', compact('kawalan'));
    }

    public function update(Request $request, Kawalan $kawalan)
    {
        if ($response = $this->checkIzin('akses_edit_kawalan_tebu')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        $kawalan->update($request->all());

        return redirect()->route('kawalans.index')->with('success', 'Kawalan Tebu berhasil diperbarui.');
    }

    public function destroy(Kawalan $kawalan)
    {
        if ($response = $this->checkIzin('akses_hapus_kawalan_tebu')) {
            return $response;
        }

        $kawalan->delete();
        return redirect()->route('kawalans.index')->with('success', 'Kawalan Tebu berhasil dihapus.');
    }
}
