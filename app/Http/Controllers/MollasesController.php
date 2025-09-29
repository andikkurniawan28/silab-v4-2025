<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mollases;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MollasesController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_timbangan_tetes')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Mollases::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_timbangan_tetes) {
                        $editUrl = route('mollases.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_timbangan_tetes) {
                        $deleteUrl = route('mollases.destroy', $row->id);
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
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('mollases.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_timbangan_tetes')) {
            return $response;
        }

        return view('mollases.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_timbangan_tetes')) {
            return $response;
        }

        $request->validate([
            'created_at'     => 'required',
            'bruto'          => 'required',
            'tarra'          => 'required',
            'netto'          => 'required',
        ]);

        Mollases::create($request->all());

        return redirect()->route('mollases.index')->with('success', 'Timbangan Tetes berhasil ditambahkan.');
    }

    public function edit(Mollases $mollase)
    {
        if ($response = $this->checkIzin('akses_edit_timbangan_tetes')) {
            return $response;
        }

        return view('mollases.edit', compact('mollase'));
    }

    public function update(Request $request, Mollases $mollase)
    {
        if ($response = $this->checkIzin('akses_edit_timbangan_tetes')) {
            return $response;
        }

        $request->validate([
            'created_at'     => 'required',
            'bruto'          => 'required',
            'tarra'          => 'required',
            'netto'          => 'required',
        ]);

        $mollase->update($request->all());

        return redirect()->route('mollases.index')->with('success', 'Timbangan Tetes berhasil diperbarui.');
    }

    public function destroy(Mollases $mollase)
    {
        if ($response = $this->checkIzin('akses_hapus_timbangan_tetes')) {
            return $response;
        }

        $mollase->delete();
        return redirect()->route('mollases.index')->with('success', 'Timbangan Tetes berhasil dihapus.');
    }
}
