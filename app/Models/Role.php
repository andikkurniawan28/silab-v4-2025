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
            ['id' => 'akses_master', 'name' => ucwords(str_replace('_', ' ', 'akses_master'))],
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
            ['id' => 'akses_daftar_titik_monitoring_perjam', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_titik_monitoring_perjam'))],
            ['id' => 'akses_tambah_titik_monitoring_perjam', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_titik_monitoring_perjam'))],
            ['id' => 'akses_edit_titik_monitoring_perjam', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_titik_monitoring_perjam'))],
            ['id' => 'akses_hapus_titik_monitoring_perjam', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_titik_monitoring_perjam'))],
            ['id' => 'akses_daftar_titik_monitoring_pershift', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_titik_monitoring_pershift'))],
            ['id' => 'akses_tambah_titik_monitoring_pershift', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_titik_monitoring_pershift'))],
            ['id' => 'akses_edit_titik_monitoring_pershift', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_titik_monitoring_pershift'))],
            ['id' => 'akses_hapus_titik_monitoring_pershift', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_titik_monitoring_pershift'))],
            ['id' => 'akses_daftar_titik_taksasi', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_titik_taksasi'))],
            ['id' => 'akses_tambah_titik_taksasi', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_titik_taksasi'))],
            ['id' => 'akses_edit_titik_taksasi', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_titik_taksasi'))],
            ['id' => 'akses_hapus_titik_taksasi', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_titik_taksasi'))],
            ['id' => 'akses_daftar_barang', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_barang'))],
            ['id' => 'akses_tambah_barang', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_barang'))],
            ['id' => 'akses_edit_barang', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_barang'))],
            ['id' => 'akses_hapus_barang', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_barang'))],
            ['id' => 'akses_daftar_wilayah', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_wilayah'))],
            ['id' => 'akses_tambah_wilayah', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_wilayah'))],
            ['id' => 'akses_edit_wilayah', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_wilayah'))],
            ['id' => 'akses_hapus_wilayah', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_wilayah'))],
            ['id' => 'akses_daftar_faktor', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_faktor'))],
            ['id' => 'akses_tambah_faktor', 'name' => ucwords(str_replace('_', ' ', 'akses_tambah_faktor'))],
            ['id' => 'akses_edit_faktor', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_faktor'))],
            ['id' => 'akses_hapus_faktor', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_faktor'))],
            ['id' => 'akses_daftar_barcode', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_barcode'))],
            ['id' => 'akses_cetak_barcode', 'name' => ucwords(str_replace('_', ' ', 'akses_cetak_barcode'))],
            ['id' => 'akses_edit_timestamp_barcode', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_timestamp_barcode'))],
            ['id' => 'akses_edit_material_barcode', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_material_barcode'))],
            ['id' => 'akses_input_data', 'name' => ucwords(str_replace('_', ' ', 'akses_input_data'))],
            ['id' => 'akses_daftar_analisa', 'name' => ucwords(str_replace('_', ' ', 'akses_daftar_analisa'))],
            ['id' => 'akses_edit_analisa', 'name' => ucwords(str_replace('_', ' ', 'akses_edit_analisa'))],
            ['id' => 'akses_hapus_analisa', 'name' => ucwords(str_replace('_', ' ', 'akses_hapus_analisa'))],
        ];
    }
}
