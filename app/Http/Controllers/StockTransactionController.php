<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\StockTransactionDetail;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StockTransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_transaksi_stok')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = StockTransaction::with(['user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                ->addColumn('details', function ($row) {
                    if ($row->details->isEmpty()) {
                        return '-';
                    }
                    $list = '<ul class="mb-0">';
                    foreach ($row->details as $detail) {
                        $list .= '<li>' . e($detail->item->name) . ' : ' . e($detail->qty) . '</li>';
                    }
                    $list .= '</ul>';
                    return $list;
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_hapus_transaksi_stok) {
                        $deleteUrl = route('stock_transactions.destroy', $row->id);
                        $buttons .= '
                            <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Hapus transaksi ini?\')" style="display:inline-block;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        ';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action', 'details'])
                ->make(true);
        }

        return view('stock_transactions.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_transaksi_stok')) {
            return $response;
        }

        $items = Item::all();
        return view('stock_transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_transaksi_stok')) {
            return $response;
        }

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:items,id',
            'items.*.qty' => 'required|numeric|min:0.01',
        ]);

        $transaction = StockTransaction::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
        ]);

        foreach ($request->items as $detail) {
            StockTransactionDetail::create([
                'stock_transaction_id' => $transaction->id,
                'item_id' => $detail['id'],
                'qty' => $detail['qty'],
                'type' => $request->type,
            ]);
        }

        return redirect()
            ->route('stock_transactions.index')
            ->with('success', 'Transaksi stok berhasil disimpan.');
    }

    public function destroy(StockTransaction $stock_transaction)
    {
        if ($response = $this->checkIzin('akses_hapus_transaksi_stok')) {
            return $response;
        }

        $stock_transaction->delete();

        return redirect()->route('stock_transactions.index')->with('success', 'Transaksi Stok berhasil dihapus.');
    }
}
