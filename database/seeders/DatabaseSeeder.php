<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'Superadmin'],
            ['name' => 'Kabag'],
            ['name' => 'Kasie'],
            ['name' => 'Kasubsie'],
            ['name' => 'Admin Laporan'],
            ['name' => 'Koordinator QC'], // Mandor
            ['name' => 'Koordinator Pabrikasi'], // KO Pabrikasi
            ['name' => 'Analis'],
            ['name' => 'Operator QC'],
            ['name' => 'Operator Pabrikasi'],
            ['name' => 'Bagian QC'],
            ['name' => 'Bagian Pabrikasi'],
            ['name' => 'Bagian Teknik'],
            ['name' => 'Bagian Tanaman'],
            ['name' => 'Bagian TUK'],
            ['name' => 'Pemimpin'],
            ['name' => 'Direksi'],
            ['name' => 'Tamu'],
        ]);
        $akses = Role::semua_akses();
        $updateData = [];
        foreach ($akses as $a) {
            $updateData[$a['id']] = 1;
        }
        Role::whereIn('id', [1,2,3])->update($updateData);

        User::insert([
            ['name' => 'Andik Kurniawan', 'username' => 'andik', 'password' => 'andik_789', 'is_active' => 1, 'role_id' => 1],
            ['name' => 'Tri Sunu Hardi', 'username' => 'sunu', 'password' => 'sunu987', 'is_active' => 1, 'role_id' => 2],
            ['name' => 'Sri Winarno', 'username' => 'win', 'password' => 'win987', 'is_active' => 1, 'role_id' => 3],
            ['name' => 'Tataq Seviarto', 'username' => 'tataq', 'password' => 'tataq987', 'is_active' => 1, 'role_id' => 3],
            ['name' => 'M. Yanuar Ananta', 'username' => 'yanuar', 'password' => 'yanuar987', 'is_active' => 1, 'role_id' => 4],
            ['name' => 'Vicky Dwi Putra', 'username' => 'vicky', 'password' => 'vicky987', 'is_active' => 1, 'role_id' => 4],
            ['name' => 'Firmansyah Agil Saputra', 'username' => 'agil', 'password' => 'agil987', 'is_active' => 1, 'role_id' => 4],
            ['name' => 'M. Aulia Ramadhan', 'username' => 'rama', 'password' => 'rama987', 'is_active' => 1, 'role_id' => 4],
            ['name' => 'M. Faiz Rosidin', 'username' => 'faiz', 'password' => 'faiz987', 'is_active' => 1, 'role_id' => 4],
            ['name' => 'Yudi Suyadi', 'username' => 'yudi', 'password' => 'yudi987', 'is_active' => 1, 'role_id' => 4],
            ['name' => 'Tutus Agustyn Rafzhanyani', 'username' => 'tutus', 'password' => 'tutus987', 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Lina Dwi Ulfa', 'username' => 'lina', 'password' => 'lina987', 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Achmad Zauzi Rifqi', 'username' => 'zauzi', 'password' => 'zauzi987', 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Risky Anggara', 'username' => 'risky', 'password' => 'risky987', 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Nico Aldy Dwi Putra', 'username' => 'nico', 'password' => 'nico987', 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Dwi Wahyu Nugroho', 'username' => 'dwi', 'password' => 'dwi987', 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Fery Ardhianto', 'username' => 'fery', 'password' => 'fery987', 'is_active' => 1, 'role_id' => 7],
            ['name' => 'Rangga Wisnu Wardhana', 'username' => 'rangga', 'password' => 'rangga987', 'is_active' => 1, 'role_id' => 7],
            ['name' => 'Dita Putri Pertiwi', 'username' => 'dita', 'password' => 'dita987', 'is_active' => 1, 'role_id' => 7],
        ]);
    }
}
