<?php

namespace App\Http\Controllers;

use App\Models\Kawalan;
use App\Models\Variety;
use Illuminate\Http\Request;
use App\Models\AnalisaOnFarm;
use Yajra\DataTables\DataTables;

class PosbrixController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_posbrix')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = AnalisaOnFarm::with(['variety', 'kawalan'])
                ->select(['id', 'spta', 'variety_id', 'kawalan_id', 'brix_posbrix', 'status', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('variety', fn($row) => $row->variety ? $row->variety->name : '-')
                ->addColumn('kawalan', fn($row) => $row->kawalan ? $row->kawalan->name : '-')
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';

                    if (Auth()->user()->role->akses_edit_posbrix) {
                        $editUrl = route('posbrixes.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }

                    if (Auth()->user()->role->akses_hapus_posbrix) {
                        $deleteUrl = route('posbrixes.destroy', $row->id);
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
                ->addColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('d-m-Y H:i') : '-')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('posbrixes.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_posbrix')) {
            return $response;
        }
        $varieties = Variety::select(['id', 'name'])->orderBy('name')->get();
        $kawalans = Kawalan::select(['id', 'name'])->orderBy('id')->get();
        return view('posbrixes.create', compact('varieties', 'kawalans'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_posbrix')) {
            return $response;
        }

        $validated = $request->validate([
            'spta' => 'nullable|string|max:8',
            'variety_id' => 'nullable|exists:varieties,id',
            'kawalan_id' => 'nullable|exists:kawalans,id',
            'brix_posbrix' => 'nullable|numeric',
            'status' => 'nullable|string|max:20',
        ]);

        AnalisaOnFarm::create($validated);

        return redirect()->route('posbrixes.index')->with('success', 'Posbrix berhasil disimpan');
    }

    public function edit($id)
    {
        if ($response = $this->checkIzin('akses_edit_posbrix')) {
            return $response;
        }

        $posbrix = AnalisaOnFarm::findOrFail($id);
        $varieties = Variety::select(['id', 'name'])->orderBy('name')->get();
        $kawalans = Kawalan::select(['id', 'name'])->orderBy('id')->get();

        return view('posbrixes.edit', compact('posbrix', 'varieties', 'kawalans'));
    }

    public function update(Request $request, $id)
    {
        if ($response = $this->checkIzin('akses_edit_posbrix')) {
            return $response;
        }

        $validated = $request->validate([
            'spta' => 'nullable|string|max:8',
            'variety_id' => 'nullable|exists:varieties,id',
            'kawalan_id' => 'nullable|exists:kawalans,id',
            'brix_posbrix' => 'nullable|numeric',
            'status' => 'nullable|string|max:20',
        ]);

        $posbrix = AnalisaOnFarm::findOrFail($id);
        $posbrix->update($validated);

        return redirect()->route('posbrixes.index')->with('success', 'Posbrix berhasil diperbarui');
    }

    public function destroy($id)
    {
        if ($response = $this->checkIzin('akses_hapus_posbrix')) {
            return $response;
        }

        $posbrix = AnalisaOnFarm::findOrFail($id);
        $posbrix->delete();

        return redirect()->route('posbrixes.index')->with('success', 'Posbrix berhasil dihapus');
    }
}
