<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Estimation;
use App\Models\EstimationSpot;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EstimationController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_taksasi_proses')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Estimation::with(['user']);
            $spots = EstimationSpot::select(['id', 'name'])->orderBy('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_taksasi_proses) {
                        $editUrl = route('estimations.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_taksasi_proses) {
                        $deleteUrl = route('estimations.destroy', $row->id);
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
                ->addColumn('result', function ($row) use ($spots) {
                    if ($spots->isEmpty()) {
                        return '-';
                    }
                    $list = '<ul class="mb-0 ps-3">';
                    foreach ($spots as $spot) {
                        $colName = 'p' . $spot->id;
                        $value   = $row->{$colName} ?? '-';
                        $list   .= '<li>' . e($spot->name) . ' : ' . e($value) . '</li>';
                    }
                    $list .= '</ul>';

                    return $list;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->rawColumns(['action', 'result'])
                ->make(true);
        }

        return view('estimations.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_taksasi_proses')) {
            return $response;
        }

        $spots = EstimationSpot::orderBy('id')->get();
        return view('estimations.create', compact('spots'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_edit_taksasi_proses')) {
            return $response;
        }

        $request->request->add(['user_id' => Auth()->user()->id]);
        Estimation::create($request->all());

        return redirect()->route('estimations.index')->with('success', 'Taksasi Proses berhasil diperbarui.');
    }

    public function edit(Estimation $estimation)
    {
        if ($response = $this->checkIzin('akses_edit_taksasi_proses')) {
            return $response;
        }

        $spots = EstimationSpot::orderBy('id')->get();
        return view('estimations.edit', compact('estimation', 'spots'));
    }

    public function update(Request $request, Estimation $estimation)
    {
        if ($response = $this->checkIzin('akses_edit_taksasi_proses')) {
            return $response;
        }

        $estimation->update($request->except(['_token', '_method']));

        return redirect()->route('estimations.index')->with('success', 'Taksasi Proses berhasil diperbarui.');
    }

    public function destroy(Estimation $estimation)
    {
        if ($response = $this->checkIzin('akses_hapus_taksasi_proses')) {
            return $response;
        }

        $estimation->delete();
        return redirect()->route('estimations.index')->with('success', 'Taksasi Proses berhasil dihapus.');
    }
}
