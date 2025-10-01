<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Carbon\Carbon;
use App\Models\Station;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StationController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_stasiun')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Station::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_stasiun) {
                        $editUrl = route('stations.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_stasiun) {
                        $deleteUrl = route('stations.destroy', $row->id);
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

        return view('stations.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_stasiun')) {
            return $response;
        }

        return view('stations.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_stasiun')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        Station::create($request->all());

        ActivityLog::log(Auth()->user()->id, "Membuat stasiun {$request->name}.");

        return redirect()->route('stations.index')->with('success', 'Stasiun berhasil ditambahkan.');
    }

    public function edit(Station $station)
    {
        if ($response = $this->checkIzin('akses_edit_stasiun')) {
            return $response;
        }

        return view('stations.edit', compact('station'));
    }

    public function update(Request $request, Station $station)
    {
        if ($response = $this->checkIzin('akses_edit_stasiun')) {
            return $response;
        }

        $old_data = Station::whereId($station->id)->get()->last();

        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        $station->update($request->all());

        ActivityLog::log(Auth()->user()->id, "Ganti stasiun {$old_data->name} ke {$request->name}.");

        return redirect()->route('stations.index')->with('success', 'Stasiun berhasil diperbarui.');
    }

    public function destroy(Station $station)
    {
        if ($response = $this->checkIzin('akses_hapus_stasiun')) {
            return $response;
        }

        $old_data = Station::whereId($station->id)->get()->last();

        ActivityLog::log(Auth()->user()->id, "Hapus stasiun {$old_data->name}.");

        $station->delete();

        return redirect()->route('stations.index')->with('success', 'Stasiun berhasil dihapus.');
    }
}
