<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Flow;
use Yajra\DataTables\DataTables;
use App\Models\FlowSpot;

class FlowNMController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_flow_nm')) {
            return $response;
        }

        if ($request->ajax()) {
            $spots = FlowSpot::select(['id', 'name'])
                ->where('id', '>', 1)
                ->orderBy('id')
                ->get();
            $data = Flow::with(['user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('result', function ($row) use ($spots) {
                    if ($spots->isEmpty()) {
                        return '-';
                    }
                    $list = '<ul class="mb-0 ps-3">';
                    $list .= '<li><strong>Tebu Tergiling</strong> : ' . e($row->sugar_cane ?? '-') . '</li>';
                    foreach ($spots as $spot) {
                        $flowCol = 'f' . $spot->id;
                        $persenCol = 'p' . $spot->id;
                        $flowVal = $row->{$flowCol} ?? '-';
                        $persenVal = $row->{$persenCol} ?? '-';
                        $list .= '<li><strong>Flow</strong> ' . e($spot->name) . ' : ' . e($flowVal) . '</li>';
                        $list .= '<li><strong>' . e($spot->name) . '%Tebu</strong> : ' . e($persenVal) . '</li>';
                    }
                    $list .= '</ul>';
                    return $list;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_hapus_flow_nm) {
                        $deleteUrl = route('flow_nm.destroy', $row->id);
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
                ->rawColumns(['action', 'result'])
                ->make(true);
        }

        return view('flow_nm.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_flow_nm')) {
            return $response;
        }
        $spots = FlowSpot::where('id', '>', 1)->select(['id', 'name'])->orderBy('id')->get();
        $last_monitoring = Flow::orderBy('id', 'desc')->get()->last();
        return view('flow_nm.create', compact('spots', 'last_monitoring'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_flow_nm')) {
            return $response;
        }

        $request->validate([
            'date' => 'required|date',
            'time' => 'required|integer|min:0|max:23',
        ]);

        $hour = str_pad($request->time, 2, '0', STR_PAD_LEFT);
        $formattedTime = $hour . ':00:00';

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['time'] = $formattedTime;

        Flow::updateOrCreate(
            ['date' => $data['date'], 'time' => $data['time']],
            $data
        );

        return redirect()
            ->route('flow_nm.index')
            ->with('success', 'Flow NM berhasil disimpan.');
    }

    public function destroy($id)
    {
        if ($response = $this->checkIzin('akses_hapus_flow_nm')) {
            return $response;
        }

        $monitoring = Flow::findOrFail($id);
        $monitoring->delete();

        return redirect()
            ->route('flow_nm.index')
            ->with('success', 'Flow NM berhasil dihapus.');
    }
}
