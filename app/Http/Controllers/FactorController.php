<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Factor;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FactorController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_faktor')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Factor::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_faktor) {
                        $editUrl = route('factors.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_faktor) {
                        $deleteUrl = route('factors.destroy', $row->id);
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

        return view('factors.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_faktor')) {
            return $response;
        }

        return view('factors.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_faktor')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'value'         => 'required|numeric',
        ]);

        Factor::create($request->all());

        ActivityLog::log(Auth()->user()->id, "Membuat faktor {$request->name} dengan nilai {$request->value}.");

        return redirect()->route('factors.index')->with('success', 'Faktor berhasil ditambahkan.');
    }

    public function edit(Factor $factor)
    {
        if ($response = $this->checkIzin('akses_edit_faktor')) {
            return $response;
        }

        return view('factors.edit', compact('factor'));
    }

    public function update(Request $request, Factor $factor)
    {
        if ($response = $this->checkIzin('akses_edit_faktor')) {
            return $response;
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'value'         => 'required|numeric',
        ]);

        ActivityLog::log(Auth()->user()->id, "Ganti faktor {$factor->name} ke {$request->value}.");

        $factor->update($request->all());

        return redirect()->route('factors.index')->with('success', 'Faktor berhasil diperbarui.');
    }

    public function destroy(Factor $factor)
    {
        if ($response = $this->checkIzin('akses_hapus_faktor')) {
            return $response;
        }

        ActivityLog::log(Auth()->user()->id, "Hapus faktor {$factor->name}.");

        $factor->delete();

        return redirect()->route('factors.index')->with('success', 'Faktor berhasil dihapus.');
    }
}
