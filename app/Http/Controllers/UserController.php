<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_user')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = User::with('role');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    return $row->role ? $row->role->name : '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-danger">Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group" role="group">';
                    if (Auth()->user()->role->akses_edit_user) {
                        $editUrl = route('users.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
                    }
                    if (Auth()->user()->role->akses_hapus_user) {
                        $deleteUrl = route('users.destroy', $row->id);
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
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('users.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_user')) {
            return $response;
        }

        $roles = Role::pluck('name', 'id');
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_user')) {
            return $response;
        }

        $request->validate([
            'role_id'      => 'required|exists:roles,id',
            'name'         => 'required|string|max:255',
            'username'        => 'required|string|max:255|unique:users,username',
            'password'     => 'required|string|min:8|confirmed',
            'organization' => 'required|string|max:255',
            'whatsapp'     => 'required|string|max:20',
            // 'is_active'    => 'required|boolean',
        ]);

        $app_key = Str::random(8);

        User::create([
            'role_id'   => $request->role_id,
            'name'      => $request->name,
            'username'  => $request->username,
            'password'  => bcrypt($request->password),
            // 'is_active' => $request->is_active ?? 1,
            'app_key'   => $app_key,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if ($response = $this->checkIzin('akses_edit_user')) {
            return $response;
        }

        $roles = Role::pluck('name', 'id');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if ($response = $this->checkIzin('akses_edit_user')) {
            return $response;
        }

        $request->validate([
            'role_id'      => 'required|exists:roles,id',
            'name'         => 'required|string|max:255',
            'username'        => 'required|string|max:255|unique:users,username,' . $user->id,
            'password'     => 'nullable|string|min:8|confirmed',
            'organization' => 'required|string|max:255',
            'whatsapp'     => 'required|string|max:20',
            'is_active'    => 'boolean',
        ]);

        $data = $request->only(['role_id', 'name', 'username', 'is_active', 'organization', 'whatsapp']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Update user utama
        $user->update($data);

        // Handle akses produk
        $aksesProduk = User::akses_produk();
        $updateAkses = [];
        foreach ($aksesProduk as $akses) {
            $col = $akses['id']; // contoh: access_to_product_1
            $updateAkses[$col] = isset($request->akses_produk[$col]) ? 1 : 0;
        }

        // Simpan ke database
        $user->update($updateAkses);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($response = $this->checkIzin('akses_hapus_user')) {
            return $response;
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
