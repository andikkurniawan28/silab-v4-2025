<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Impurity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ImpurityController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_kotoran_tebu')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Impurity::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_kotoran_tebu) {
                        $editUrl = route('impurities.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_kotoran_tebu) {
                        $deleteUrl = route('impurities.destroy', $row->id);
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

        return view('impurities.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_kotoran_tebu')) {
            return $response;
        }

        return view('impurities.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_kotoran_tebu')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        Impurity::create($request->all());

        return redirect()->route('impurities.index')->with('success', 'Kotoran Tebu berhasil ditambahkan.');
    }

    public function edit(Impurity $impurity)
    {
        if ($response = $this->checkIzin('akses_edit_kotoran_tebu')) {
            return $response;
        }

        return view('impurities.edit', compact('impurity'));
    }

    public function update(Request $request, Impurity $impurity)
    {
        if ($response = $this->checkIzin('akses_edit_kotoran_tebu')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        $impurity->update($request->all());

        return redirect()->route('impurities.index')->with('success', 'Kotoran Tebu berhasil diperbarui.');
    }

    public function destroy(Impurity $impurity)
    {
        if ($response = $this->checkIzin('akses_hapus_kotoran_tebu')) {
            return $response;
        }

        $impurity->delete();
        return redirect()->route('impurities.index')->with('success', 'Kotoran Tebu berhasil dihapus.');
    }
}
