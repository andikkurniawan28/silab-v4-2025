<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AnalisaOnFarm;
use Yajra\DataTables\DataTables;

class CoreSampleController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_core_sample')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = AnalisaOnFarm::select(['id', 'kartu_core', 'nomor_antrian', 'nopol', 'register', 'brix_core', 'pol_core', 'pol_baca_core', 'rendemen_core', 'core_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';

                    if (Auth()->user()->role->akses_edit_core_sample) {
                        $editUrl = route('core_samples.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }

                    if (Auth()->user()->role->akses_hapus_core_sample) {
                        $deleteUrl = route('core_samples.destroy', $row->id);
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
                ->addColumn('core_at', fn($row) => $row->core_at ? Carbon::parse($row->core_at)->format('d-m-Y H:i') : '-')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('core_samples.index');
    }

    public function edit($id)
    {
        if ($response = $this->checkIzin('akses_edit_core_sample')) {
            return $response;
        }

        $core_sample = AnalisaOnFarm::findOrFail($id);

        return view('core_samples.edit', compact('core_sample'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->checkIzin('akses_edit_core_sample')) {
            return $response;
        }

        $core_sample = AnalisaOnFarm::findOrFail($id);
        $core_sample->update($request->except(['_token', '_method', 'id']));

        return redirect()->route('core_samples.index')->with('success', 'Core Sample berhasil diperbarui');
    }

    public function destroy($id)
    {
        if ($response = $this->checkIzin('akses_hapus_core_sample')) {
            return $response;
        }

        $core_sample = AnalisaOnFarm::findOrFail($id);
        $core_sample->delete();

        return redirect()->route('core_samples.index')->with('success', 'Core Sample berhasil dihapus');
    }
}
