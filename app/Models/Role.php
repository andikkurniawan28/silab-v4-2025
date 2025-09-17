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
        ];
    }
}
