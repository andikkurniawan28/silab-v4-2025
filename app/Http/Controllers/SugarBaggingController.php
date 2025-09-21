<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SugarBagging;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SugarBaggingController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_gula_dikarungi')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = SugarBagging::with(['user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_hapus_gula_dikarungi) {
                        $deleteUrl = route('sugar_baggings.destroy', $row->id);
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
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->rawColumns(['action', 'result'])
                ->make(true);
        }

        return view('sugar_baggings.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_gula_dikarungi')) {
            return $response;
        }

        $last_bagging = SugarBagging::where('date', date('Y-m-d'))->get()->last();

        return view('sugar_baggings.create', compact('last_bagging'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_gula_dikarungi')) {
            return $response;
        }

        $hour = str_pad($request->time, 2, '0', STR_PAD_LEFT);
        $formattedTime = $hour . ':00:00';

        $request->request->add(['user_id' => Auth()->user()->id, 'time' => $formattedTime]);
        SugarBagging::create($request->all());

        return redirect()->route('sugar_baggings.index')->with('success', 'Gula Dikarungi berhasil diperbarui.');
    }

    public function edit(SugarBagging $sugar_bagging)
    {
        if ($response = $this->checkIzin('akses_edit_gula_dikarungi')) {
            return $response;
        }

        return view('sugar_baggings.edit', compact('sugar_bagging'));
    }

    public function update(Request $request, SugarBagging $sugar_bagging)
    {
        if ($response = $this->checkIzin('akses_edit_gula_dikarungi')) {
            return $response;
        }

        $sugar_bagging->update($request->except(['_token', '_method']));

        return redirect()->route('sugar_baggings.index')->with('success', 'Gula Dikarungi berhasil diperbarui.');
    }

    public function destroy(SugarBagging $sugar_bagging)
    {
        if ($response = $this->checkIzin('akses_hapus_gula_dikarungi')) {
            return $response;
        }

        $sugar_bagging->delete();
        return redirect()->route('sugar_baggings.index')->with('success', 'Gula Dikarungi berhasil dihapus.');
    }
}
