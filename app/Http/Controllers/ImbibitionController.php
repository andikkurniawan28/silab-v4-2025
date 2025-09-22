<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Flow;
use App\Models\FlowSpot;
use App\Models\Imbibition;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ImbibitionController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_imbibisi')) {
            return $response;
        }

        if ($request->ajax()) {
            $spots = FlowSpot::with('unit')->select(['id', 'name', 'unit_id'])
                ->where('id', 1)
                ->orderBy('id')
                ->get();
            $data = Imbibition::with(['user']);
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
                    // $list .= '<li><strong>Tebu Tergiling</strong> : ' . e($row->sugar_cane ?? '-') . 'Ku</li>';
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
                ->addColumn('date', function ($row) {
                    return $row->date
                        ? Carbon::parse($row->date)->format('d-m-Y')
                        : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_imbibisi) {
                        $editUrl = route('imbibisi.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_imbibisi) {
                        $deleteUrl = route('imbibisi.destroy', $row->id);
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

        return view('imbibisi.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_imbibisi')) {
            return $response;
        }
        $spots = FlowSpot::where('id', 1)
            ->select(['id', 'name'])
            ->orderBy('id')
            ->get();
        $lastFlow = Flow::orderBy('id', 'desc')->get()->last();
        $last_monitoring = Imbibition::orderBy('id', 'desc')->get()->last();
        return view('imbibisi.create', compact('last_monitoring', 'spots', 'lastFlow'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_imbibisi')) {
            return $response;
        }

        $request->validate([
            'date' => 'required|date',
            'time' => 'required|integer|min:0|max:23',
        ]);

        $hour = str_pad($request->time, 2, '0', STR_PAD_LEFT);
        $formattedTime = $hour . ':00:00';

        $exists = Imbibition::where('date', $request->date)
            ->where('time', $formattedTime)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('imbibisi.create')
                ->with('failed', 'Data pada tanggal dan jam tersebut sudah ada!');
        }

        $request->merge([
            'user_id' => auth()->id(),
            'time' => $formattedTime
        ]);

        Imbibition::create($request->all());

        return redirect()
            ->route('imbibisi.index')
            ->with('success', 'Imbibisi berhasil disimpan.');
    }

    public function edit($id)
    {
        if ($response = $this->checkIzin('akses_edit_imbibisi')) {
            return $response;
        }

        $imbibisi = Imbibition::findOrFail($id);
        $spots = FlowSpot::where('id', 1)
            ->select(['id', 'name'])
            ->orderBy('id')
            ->get();

        return view('imbibisi.edit', compact('imbibisi', 'spots'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->checkIzin('akses_edit_imbibisi')) {
            return $response;
        }

        $request->validate([
            'date' => 'required|date',
            'time' => 'required|integer|min:0|max:23',
        ]);

        $hour = str_pad($request->time, 2, '0', STR_PAD_LEFT);
        $formattedTime = $hour . ':00:00';

        $exists = Imbibition::where('date', $request->date)
            ->where('time', $formattedTime)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('imbibisi.edit', $id)
                ->with('failed', 'Data pada tanggal dan jam tersebut sudah ada!');
        }

        $flow = Imbibition::findOrFail($id);
        $flow->update(array_merge(
            $request->all(),
            [
                'user_id' => auth()->id(),
                'time'    => $formattedTime
            ]
        ));

        return redirect()
            ->route('imbibisi.index')
            ->with('success', 'Imbibisi berhasil diperbarui.');
    }


    public function destroy($id)
    {
        if ($response = $this->checkIzin('akses_hapus_imbibisi')) {
            return $response;
        }

        $monitoring = Imbibition::findOrFail($id);
        $monitoring->delete();

        return redirect()
            ->route('imbibisi.index')
            ->with('success', 'Imbibisi berhasil dihapus.');
    }
}
