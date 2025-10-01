<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Flow;
use App\Models\FlowSpot;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FlowNMController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_flow_nm')) {
            return $response;
        }

        if ($request->ajax()) {
            $spots = FlowSpot::with('unit')->select(['id', 'name', 'unit_id'])
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
                    $list .= '<li><strong>Tebu Tergiling</strong> : ' . e($row->sugar_cane ?? '-') . 'Ku</li>';
                    foreach ($spots as $spot) {
                        $flowCol = 'f' . $spot->id;
                        $persenCol = 'p' . $spot->id;
                        $flowVal = $row->{$flowCol} ?? '-';
                        $persenVal = $row->{$persenCol} ?? '-';
                        $list .= '<li><strong>Flow ' . e($spot->name) . '</strong> : ' . e($flowVal) . ' ' . e($spot->unit->name) . '</li>';
                        $list .= '<li><strong>' . e($spot->name) . '%Tebu</strong> : ' . e($persenVal) . '%</li>';
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
                    if (Auth()->user()->role->akses_edit_flow_nm) {
                        $editUrl = route('flow_nm.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
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

        $createdAt = Carbon::parse($request->date)
            ->setHour($request->time)
            ->setMinute(0)
            ->setSecond(0);

        $startTime = $createdAt->format('H:i');
        $endTime = $createdAt->copy()->addHour()->subSecond()->format('H:i');
        $timerange = "{$startTime}-{$endTime}";

        $exists = Flow::where('created_at', $createdAt)
            ->where('timerange', $timerange)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('flow_nm.create')
                ->with('failed', 'Data pada tanggal dan jam tersebut sudah ada!');
        }

        $request->merge([
            'user_id' => auth()->id(),
            'created_at' => $createdAt,
            'timerange' => $timerange,
        ]);

        Flow::create($request->except(['date', 'time']));

        $data = json_encode($request);

        ActivityLog::log(Auth()->user()->id, "Input Flow {$data}.");

        return redirect()
            ->route('flow_nm.index')
            ->with('success', 'Flow NM berhasil disimpan.');
    }

    public function edit($id)
    {
        if ($response = $this->checkIzin('akses_edit_flow_nm')) {
            return $response;
        }

        $flow = Flow::findOrFail($id);
        $spots = FlowSpot::where('id', '>', 1)
            ->select(['id', 'name'])
            ->orderBy('id')
            ->get();

        return view('flow_nm.edit', compact('flow', 'spots'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->checkIzin('akses_edit_flow_nm')) {
            return $response;
        }

        $request->validate([
            'date' => 'required|date',
            'time' => 'required|integer|min:0|max:23',
        ]);

        $createdAt = Carbon::parse($request->date)
            ->setHour($request->time)
            ->setMinute(0)
            ->setSecond(0);

        $startTime = $createdAt->format('H:i');
        $endTime = $createdAt->copy()->addHour()->subSecond()->format('H:i');
        $timerange = "{$startTime}-{$endTime}";

        $flow = Flow::findOrFail($id);
        $flow->update(array_merge(
            $request->except(['date', 'time']),
            [
                'user_id'    => auth()->id(),
                'created_at' => $createdAt,
                'timerange'  => $timerange,
            ]
        ));

        $data = json_encode($flow);

        ActivityLog::log(Auth()->user()->id, "Edit Flow {$data}.");

        return redirect()
            ->route('flow_nm.index')
            ->with('success', 'Flow NM berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if ($response = $this->checkIzin('akses_hapus_flow_nm')) {
            return $response;
        }

        $monitoring = Flow::findOrFail($id);

        $data = json_encode($monitoring);

        ActivityLog::log(Auth()->user()->id, "Hapus Flow {$data}.");

        $monitoring->delete();

        return redirect()
            ->route('flow_nm.index')
            ->with('success', 'Flow NM berhasil dihapus.');
    }
}
