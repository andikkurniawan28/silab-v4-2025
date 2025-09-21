<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BagTest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class BagTestController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_uji_karung')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = BagTest::with(['user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_uji_karung) {
                        $editUrl = route('bag_tests.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_uji_karung) {
                        $deleteUrl = route('bag_tests.destroy', $row->id);
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
                ->addColumn('result', function ($row) {
                    $list = '<ul class="mb-0 ps-3">';

                    // Outer
                    $list .= '<li><strong>Outer</strong></li>';
                    $list .= '<ul>';
                    $list .= '<li>Panjang: ' . e($row->p_nilai_outer ?? '-') . ' (' . e($row->p_ket_outer ?? '-') . ')</li>';
                    $list .= '<li>Lebar: ' . e($row->l_nilai_outer ?? '-') . ' (' . e($row->l_ket_outer ?? '-') . ')</li>';
                    $list .= '<li>Berat: ' . e($row->berat_outer ?? '-') . ' (' . e($row->berat_outer_ket ?? '-') . ')</li>';
                    $list .= '<li>Raw: ' . e($row->raw_outer ?? '-') . '</li>';
                    $list .= '<li>Tebal: ' . e($row->tebal_outer ?? '-') . ' (' . e($row->tebal_outer_ket ?? '-') . ')</li>';
                    $list .= '</ul>';

                    // Inner
                    $list .= '<li><strong>Inner</strong></li>';
                    $list .= '<ul>';
                    $list .= '<li>Panjang: ' . e($row->p_nilai_inner ?? '-') . ' (' . e($row->p_ket_inner ?? '-') . ')</li>';
                    $list .= '<li>Lebar: ' . e($row->l_nilai_inner ?? '-') . ' (' . e($row->l_ket_inner ?? '-') . ')</li>';
                    $list .= '<li>Berat: ' . e($row->berat_inner ?? '-') . ' (' . e($row->berat_inner_ket ?? '-') . ')</li>';
                    $list .= '<li>Raw: ' . e($row->raw_inner ?? '-') . '</li>';
                    $list .= '<li>Tebal: ' . e($row->tebal_inner ?? '-') . ' (' . e($row->tebal_inner_ket ?? '-') . ')</li>';
                    $list .= '</ul>';

                    // Mesh
                    $list .= '<li><strong>Mesh</strong></li>';
                    $list .= '<ul>';
                    $list .= '<li>Alas: ' . e($row->mesh_alas ?? '-') . ' (' . e($row->mesh_ket_alas ?? '-') . ')</li>';
                    $list .= '<li>Tinggi: ' . e($row->mesh_tinggi ?? '-') . ' (' . e($row->mesh_ket_tinggi ?? '-') . ')</li>';
                    $list .= '</ul>';

                    // Denier
                    $list .= '<li><strong>Denier</strong></li>';
                    $list .= '<ul>';
                    $list .= '<li>Nilai: ' . e($row->denier_nilai ?? '-') . ' (' . e($row->denier_ket ?? '-') . ')</li>';
                    $list .= '</ul>';

                    $list .= '</ul>';
                    return $list;
                })
                ->rawColumns(['action', 'result'])
                ->make(true);
        }

        return view('bag_tests.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_uji_karung')) {
            return $response;
        }

        return view('bag_tests.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_uji_karung')) {
            return $response;
        }

        $request->validate([
            'test_date' => 'required|date',
            'arrival_date' => 'required|date',
            'batch' => 'required|integer',
            'dimensi' => 'required|array',
            'berat' => 'required|array',
            'tebal' => 'required|array',
            'mesh' => 'required|array',
            'denier' => 'required|array',
        ]);

        foreach ($request->dimensi as $index => $dimensi) {
            $p_nilai_outer = $dimensi['p_nilai_outer'] ?? 0;
            $l_nilai_outer = $dimensi['l_nilai_outer'] ?? 0;
            $p_nilai_inner = $dimensi['p_nilai_inner'] ?? 0;
            $l_nilai_inner = $dimensi['l_nilai_inner'] ?? 0;

            $berat_outer = $request->berat[$index]['outer'] ?? 0;
            $berat_inner = $request->berat[$index]['inner'] ?? 0;

            $raw_outer = $request->tebal[$index]['raw_outer'] ?? 0;
            $tebal_outer = $request->tebal[$index]['outer'] ?? 0;
            $raw_inner = $request->tebal[$index]['raw_inner'] ?? 0;
            $tebal_inner = $request->tebal[$index]['inner'] ?? 0;

            $mesh_alas = $request->mesh[$index]['alas'] ?? 0;
            $mesh_tinggi = $request->mesh[$index]['tinggi'] ?? 0;

            $denier_nilai = $request->denier[$index]['nilai'] ?? 0;

            BagTest::create([
                'test_date'  => $request->test_date,
                'arrival_date' => $request->arrival_date,
                'batch' => $request->batch,

                // Dimensi
                'p_nilai_outer' => $p_nilai_outer,
                'p_ket_outer'   => $this->cekKesesuaian('p_nilai_outer', $p_nilai_outer),
                'l_nilai_outer' => $l_nilai_outer,
                'l_ket_outer'   => $this->cekKesesuaian('l_nilai_outer', $l_nilai_outer),
                'p_nilai_inner' => $p_nilai_inner,
                'p_ket_inner'   => $this->cekKesesuaian('p_nilai_inner', $p_nilai_inner),
                'l_nilai_inner' => $l_nilai_inner,
                'l_ket_inner'   => $this->cekKesesuaian('l_nilai_inner', $l_nilai_inner),

                // Berat
                'berat_outer'   => $berat_outer,
                'berat_outer_ket' => $this->cekKesesuaian('berat_outer', $berat_outer),
                'berat_inner'   => $berat_inner,
                'berat_inner_ket' => $this->cekKesesuaian('berat_inner', $berat_inner),

                // Tebal
                'raw_outer'     => $raw_outer,
                'tebal_outer'   => $tebal_outer,
                'tebal_outer_ket' => $this->cekKesesuaian('tebal_outer', $tebal_outer),
                'raw_inner'     => $raw_inner,
                'tebal_inner'   => $tebal_inner,
                'tebal_inner_ket' => $this->cekKesesuaian('tebal_inner', $tebal_inner),

                // Mesh
                'mesh_alas'     => $mesh_alas,
                'mesh_ket_alas' => $this->cekKesesuaian('mesh_alas', $mesh_alas),
                'mesh_tinggi'   => $mesh_tinggi,
                'mesh_ket_tinggi' => $this->cekKesesuaian('mesh_tinggi', $mesh_tinggi),

                // Denier
                'denier_nilai'  => $denier_nilai,
                'denier_ket'    => $this->cekKesesuaian('denier_nilai', $denier_nilai),

                // User
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('bag_tests.index')->with('success', 'Uji Karung berhasil disimpan');
    }

    public function edit(BagTest $bag_test)
    {
        if ($response = $this->checkIzin('akses_edit_uji_karung')) {
            return $response;
        }

        return view('bag_tests.edit', compact('bag_test'));
    }

    public function update(Request $request, BagTest $bag_test)
    {
        if ($response = $this->checkIzin('akses_edit_uji_karung')) {
            return $response;
        }

        $bag_test->update($request->except(['_token', '_method']));

        return redirect()->route('bag_tests.index')->with('success', 'Uji Karung berhasil diperbarui.');
    }

    public function destroy(BagTest $bag_test)
    {
        if ($response = $this->checkIzin('akses_hapus_uji_karung')) {
            return $response;
        }

        $bag_test->delete();
        return redirect()->route('bag_tests.index')->with('success', 'Uji Karung berhasil dihapus.');
    }

    private function cekKesesuaian($field, $nilai)
    {
        // Standar nilai
        $standar = [
            'p_nilai_outer' => 97,
            'l_nilai_outer' => 57,
            'p_nilai_inner' => 110,
            'l_nilai_inner' => 60,
            'berat_outer'   => 110,
            'berat_inner'   => 36,
            'tebal_outer'   => 0.175,
            'tebal_inner'   => 0.03,
            'mesh_alas'     => 12,
            'mesh_tinggi'   => 12,
            'denier_nilai'  => 900,
        ];

        if (!isset($standar[$field]) || !is_numeric($nilai)) {
            return '-'; // kalau standar tidak ada / nilainya bukan angka
        }

        $std = $standar[$field];
        $toleransi = $std * 0.05; // toleransi 5%

        return (abs($nilai - $std) <= $toleransi) ? 'Sesuai' : 'Tidak Sesuai';
    }
}
