<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AriCard;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AriCardController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_gelas_ari')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = AriCard::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_hapus_gelas_ari) {
                        $deleteUrl = route('ari_cards.destroy', $row->id);
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

        return view('ari_cards.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_gelas_ari')) {
            return $response;
        }

        return view('ari_cards.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_gelas_ari')) {
            return $response;
        }

        AriCard::create($request->all());

        return redirect()->route('ari_cards.index')->with('success', 'Gelas Ari berhasil ditambahkan.');
    }

    public function edit(AriCard $ari_card)
    {
        if ($response = $this->checkIzin('akses_edit_gelas_ari')) {
            return $response;
        }

        return view('ari_cards.edit', compact('ari_card'));
    }

    public function update(Request $request, AriCard $ari_card)
    {
        if ($response = $this->checkIzin('akses_edit_gelas_ari')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        $ari_card->update($request->all());

        return redirect()->route('ari_cards.index')->with('success', 'Gelas Ari berhasil diperbarui.');
    }

    public function destroy(AriCard $ari_card)
    {
        if ($response = $this->checkIzin('akses_hapus_gelas_ari')) {
            return $response;
        }

        $ari_card->delete();
        return redirect()->route('ari_cards.index')->with('success', 'Gelas Ari berhasil dihapus.');
    }
}
