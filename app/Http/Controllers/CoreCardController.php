<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\CoreCard;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CoreCardController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_gelas_core')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = CoreCard::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_hapus_gelas_core) {
                        $deleteUrl = route('core_cards.destroy', $row->id);
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

        return view('core_cards.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_gelas_core')) {
            return $response;
        }

        return view('core_cards.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_gelas_core')) {
            return $response;
        }

        CoreCard::create($request->all());

        return redirect()->route('core_cards.index')->with('success', 'Gelas Core berhasil ditambahkan.');
    }

    public function edit(CoreCard $core_card)
    {
        if ($response = $this->checkIzin('akses_edit_gelas_core')) {
            return $response;
        }

        return view('core_cards.edit', compact('core_card'));
    }

    public function update(Request $request, CoreCard $core_card)
    {
        if ($response = $this->checkIzin('akses_edit_gelas_core')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        $core_card->update($request->all());

        return redirect()->route('core_cards.index')->with('success', 'Gelas Core berhasil diperbarui.');
    }

    public function destroy(CoreCard $core_card)
    {
        if ($response = $this->checkIzin('akses_hapus_gelas_core')) {
            return $response;
        }

        $core_card->delete();
        return redirect()->route('core_cards.index')->with('success', 'Gelas Core berhasil dihapus.');
    }
}
