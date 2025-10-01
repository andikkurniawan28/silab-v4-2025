<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_log_aktifitas')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = ActivityLog::with(['user']);
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
                ->make(true);
        }

        return view('activity_logs.index');
    }
}
