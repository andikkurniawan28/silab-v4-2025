<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\StockTransactionDetail;

class StockTransactionDetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_transaksi_stok')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = StockTransactionDetail::with(['item', 'stockTransaction']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('item', function ($row) {
                    return $row->item ? $row->item->name : '-';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d-m-Y H:i')
                        : '-';
                })
                // ->rawColumns(['action', 'details'])
                ->make(true);
        }

        return view('stock_transaction_details.index');
    }
}
