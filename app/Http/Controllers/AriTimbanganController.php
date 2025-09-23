<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AnalisaOnFarm;
use Yajra\DataTables\DataTables;

class AriTimbanganController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_ari_timbangan')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = AnalisaOnFarm::select(['id', 'kartu_ari', 'nomor_antrian', 'nopol', 'register', 'brix_ari', 'pol_ari', 'pol_baca_ari', 'rendemen_ari', 'ari_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';

                    if (Auth()->user()->role->akses_edit_ari_timbangan) {
                        $editUrl = route('ari_timbangans.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }

                    if (Auth()->user()->role->akses_hapus_ari_timbangan) {
                        $deleteUrl = route('ari_timbangans.destroy', $row->id);
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
                ->addColumn('ari_at', fn($row) => $row->ari_at ? Carbon::parse($row->ari_at)->format('d-m-Y H:i') : '-')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('ari_timbangans.index');
    }

    public function edit($id)
    {
        if ($response = $this->checkIzin('akses_edit_ari_timbangan')) {
            return $response;
        }

        $ari_timbangan = AnalisaOnFarm::findOrFail($id);

        return view('ari_timbangans.edit', compact('ari_timbangan'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->checkIzin('akses_edit_ari_timbangan')) {
            return $response;
        }

        $ari_timbangan = AnalisaOnFarm::findOrFail($id);
        $ari_timbangan->update($request->except(['_token', '_method', 'id']));

        return redirect()->route('ari_timbangans.index')->with('success', 'ARI Timbangan berhasil diperbarui');
    }

    public function destroy($id)
    {
        if ($response = $this->checkIzin('akses_hapus_ari_timbangan')) {
            return $response;
        }

        $ari_timbangan = AnalisaOnFarm::findOrFail($id);
        $ari_timbangan->delete();

        return redirect()->route('ari_timbangans.index')->with('success', 'ARI Timbangan berhasil dihapus');
    }
}
