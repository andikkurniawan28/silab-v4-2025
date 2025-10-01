<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Impurity;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\AnalisaOnFarm;
use Yajra\DataTables\DataTables;

class PenilaianMbsController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_penilaian_mbs')) {
            return $response;
        }

        if ($request->ajax()) {
            $impurities = Impurity::select(['id', 'name'])->orderBy('id')->get();

            $selectCols = ['id', 'kartu_ari', 'nomor_antrian', 'nopol', 'register', 'mbs_at', 'rafaksi'];
            foreach ($impurities as $imp) {
                $selectCols[] = 'p' . $imp->id;
            }

            $data = AnalisaOnFarm::select($selectCols);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('impurities', function ($row) use ($impurities) {
                    $list = '<ul class="mb-0 ps-3">';
                    foreach ($impurities as $imp) {
                        $col = 'p' . $imp->id;
                        $val = $row->$col ?? 0;
                        if ($val == 1) {
                            $list .= '<li>' . e($imp->name) . ' ✅</li>';
                        }
                    }
                    $list .= '</ul>';
                    return $list === '<ul class="mb-0 ps-3"></ul>' ? '-' : $list;
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';

                    if (Auth()->user()->role->akses_edit_penilaian_mbs) {
                        $editUrl = route('penilaian_mbss.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }

                    if (Auth()->user()->role->akses_hapus_penilaian_mbs) {
                        $deleteUrl = route('penilaian_mbss.destroy', $row->id);
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
                ->addColumn('mbs_at', fn($row) => $row->mbs_at ? Carbon::parse($row->mbs_at)->format('d-m-Y H:i') : '-')
                ->rawColumns(['action', 'impurities'])
                ->make(true);
        }

        $impurities = Impurity::select(['id','name'])->orderBy('id')->get();
        return view('penilaian_mbss.index', compact('impurities'));
    }


    public function edit($id)
    {
        if ($response = $this->checkIzin('akses_edit_penilaian_mbs')) {
            return $response;
        }

        $penilaian_mbs = AnalisaOnFarm::findOrFail($id);
        $impurities = Impurity::select(['id','name'])->orderBy('id')->get();

        return view('penilaian_mbss.edit', compact('penilaian_mbs', 'impurities'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->checkIzin('akses_edit_penilaian_mbs')) {
            return $response;
        }

        $penilaian_mbs = AnalisaOnFarm::findOrFail($id);
        $penilaian_mbs->update($request->except(['_token', '_method', 'id']));

        ActivityLog::log(Auth()->user()->id, "Edit Penilaian MBS {$penilaian_mbs}.");

        return redirect()->route('penilaian_mbss.index')->with('success', 'Penilaian MBS berhasil diperbarui');
    }

    public function destroy($id)
    {
        if ($response = $this->checkIzin('akses_hapus_penilaian_mbs')) {
            return $response;
        }

        $penilaian_mbs = AnalisaOnFarm::findOrFail($id);

        ActivityLog::log(Auth()->user()->id, "Hapus Penilaian MBS {$penilaian_mbs}.");

        $penilaian_mbs->delete();

        return redirect()->route('penilaian_mbss.index')->with('success', 'Penilaian MBS berhasil dihapus');
    }
}
