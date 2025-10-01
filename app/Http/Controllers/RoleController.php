<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_jabatan')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Role::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_jabatan) {
                        $editUrl = route('roles.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_jabatan) {
                        $deleteUrl = route('roles.destroy', $row->id);
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

        return view('roles.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_jabatan')) {
            return $response;
        }

        $semua_akses = Role::semua_akses();

        return view('roles.create', compact('semua_akses'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_jabatan')) {
            return $response;
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->only(['name']);

        foreach (Role::semua_akses() as $akses) {
            $field = $akses['id'];
            $data[$field] = $request->has($field) ? 1 : 0;
        }

        Role::create($data);

        ActivityLog::log(Auth()->user()->id, "Tambah Jabatan {$data}.");

        return redirect()->route('roles.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }


    public function edit(Role $role)
    {
        if ($response = $this->checkIzin('akses_edit_jabatan')) {
            return $response;
        }

        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        if ($response = $this->checkIzin('akses_edit_jabatan')) {
            return $response;
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->only(['name']);

        foreach (Role::semua_akses() as $akses) {
            $field = $akses['id'];
            $data[$field] = $request->has($field) ? 1 : 0;
        }

        $role->update($data);

        ActivityLog::log(Auth()->user()->id, "Edit Jabatan {$data}.");

        return redirect()->route('roles.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        if ($response = $this->checkIzin('akses_hapus_jabatan')) {
            return $response;
        }

        ActivityLog::log(Auth()->user()->id, "Hapus Jabatan {$role}.");

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}
