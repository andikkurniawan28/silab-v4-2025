<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function semua_akses()
    {
        return [
            ['id' => 'akses_daftar_jabatan', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_jabatan'))],
            ['id' => 'akses_tambah_jabatan', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_jabatan'))],
            ['id' => 'akses_edit_jabatan', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_jabatan'))],
            ['id' => 'akses_hapus_jabatan', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_jabatan'))],
            ['id' => 'akses_daftar_user', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_user'))],
            ['id' => 'akses_tambah_user', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_user'))],
            ['id' => 'akses_edit_user', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_user'))],
            ['id' => 'akses_hapus_user', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_user'))],
            ['id' => 'akses_daftar_stasiun', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_stasiun'))],
            ['id' => 'akses_tambah_stasiun', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_stasiun'))],
            ['id' => 'akses_edit_stasiun', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_stasiun'))],
            ['id' => 'akses_hapus_stasiun', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_stasiun'))],
            ['id' => 'akses_daftar_satuan', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_satuan'))],
            ['id' => 'akses_tambah_satuan', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_satuan'))],
            ['id' => 'akses_edit_satuan', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_satuan'))],
            ['id' => 'akses_hapus_satuan', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_satuan'))],
            ['id' => 'akses_daftar_parameter', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_parameter'))],
            ['id' => 'akses_tambah_parameter', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_parameter'))],
            ['id' => 'akses_edit_parameter', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_parameter'))],
            ['id' => 'akses_hapus_parameter', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_parameter'))],
            ['id' => 'akses_daftar_material', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_material'))],
            ['id' => 'akses_tambah_material', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_material'))],
            ['id' => 'akses_edit_material', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_material'))],
            ['id' => 'akses_hapus_material', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_material'))],
        ];
    }
}
