<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_barang')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Item::with('unit');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('unit', function ($row) {
                    return $row->unit ? $row->unit->name : '-';
                })
                ->addColumn('saldo', function ($row) {
                    return $row->saldo() ? $row->saldo() : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_barang) {
                        $editUrl = route('items.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_barang) {
                        $deleteUrl = route('items.destroy', $row->id);
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

        return view('items.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_barang')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');
        return view('items.create', compact('units'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_barang')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        if ($response = $this->checkIzin('akses_edit_barang')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');
        return view('items.edit', compact('item', 'units'));
    }

    public function update(Request $request, Item $item)
    {
        if ($response = $this->checkIzin('akses_edit_barang')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        if ($response = $this->checkIzin('akses_hapus_barang')) {
            return $response;
        }

        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
