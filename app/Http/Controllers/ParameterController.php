<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Parameter;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_parameter')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Parameter::with('unit');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('unit', function ($row) {
                    return $row->unit ? $row->unit->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_parameter) {
                        $editUrl = route('parameters.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_parameter) {
                        $deleteUrl = route('parameters.destroy', $row->id);
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

        return view('parameters.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_parameter')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');

        return view('parameters.create', compact('units'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_parameter')) {
            return $response;
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        Parameter::create($request->all());

        $unit = Unit::whereId($request->unit_id)->get()->last();

        ActivityLog::log(Auth()->user()->id, "Membuat parameter {$request->name} dengan satuan {$unit->name}.");

        return redirect()->route('parameters.index')->with('success', 'Parameter berhasil ditambahkan.');
    }

    public function edit(Parameter $parameter)
    {
        if ($response = $this->checkIzin('akses_edit_parameter')) {
            return $response;
        }

        $units = Unit::pluck('name', 'id');

        return view('parameters.edit', compact('parameter', 'units'));
    }

    public function update(Request $request, Parameter $parameter)
    {
        if ($response = $this->checkIzin('akses_edit_parameter')) {
            return $response;
        }

        $old_data = Parameter::with(['unit'])->whereId($parameter->id)->get()->last();

        $request->validate([
            'name'    => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        $parameter->update($request->all());

        $unit = Unit::whereId($request->unit_id)->get()->last();

        ActivityLog::log(Auth()->user()->id, "Ganti parameter {$old_data->name} ke {$request->name}, satuan {$old_data->unit->name} ke {$unit->name}.");

        return redirect()->route('parameters.index')->with('success', 'Parameter berhasil diperbarui.');
    }

    public function destroy(Parameter $parameter)
    {
        if ($response = $this->checkIzin('akses_hapus_parameter')) {
            return $response;
        }

        $parameter->delete();

        ActivityLog::log(Auth()->user()->id, "Hapus parameter {$parameter->name}.");

        return redirect()->route('parameters.index')->with('success', 'Parameter berhasil dihapus.');
    }
}
