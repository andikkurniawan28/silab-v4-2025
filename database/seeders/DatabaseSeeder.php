<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\MonitoringHourlySpot;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Station;
use App\Models\Parameter;
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
            ['name' => 'Mandor QC'], // Mandor
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
            ['name' => 'Andik Kurniawan', 'username' => 'andik', 'password' => bcrypt('andik_789'), 'is_active' => 1, 'role_id' => 1],
            ['name' => 'Tri Sunu Hardi', 'username' => 'sunu', 'password' => bcrypt('sunu987'), 'is_active' => 1, 'role_id' => 2],
            ['name' => 'Sri Winarno', 'username' => 'win', 'password' => bcrypt('win987'), 'is_active' => 1, 'role_id' => 3],
            ['name' => 'Tataq Seviarto', 'username' => 'tataq', 'password' => bcrypt('tataq987'), 'is_active' => 1, 'role_id' => 3],
            ['name' => 'M. Yanuar Ananta', 'username' => 'yanuar', 'password' => bcrypt('yanuar987'), 'is_active' => 1, 'role_id' => 4],
            ['name' => 'Vicky Dwi Putra', 'username' => 'vicky', 'password' => bcrypt('vicky987'), 'is_active' => 1, 'role_id' => 4],
            ['name' => 'Firmansyah Agil Saputra', 'username' => 'agil', 'password' => bcrypt('agil987'), 'is_active' => 1, 'role_id' => 4],
            ['name' => 'M. Aulia Ramadhan', 'username' => 'rama', 'password' => bcrypt('rama987'), 'is_active' => 1, 'role_id' => 4],
            ['name' => 'M. Faiz Rosidin', 'username' => 'faiz', 'password' => bcrypt('faiz987'), 'is_active' => 1, 'role_id' => 4],
            ['name' => 'Yudi Suyadi', 'username' => 'yudi', 'password' => bcrypt('yudi987'), 'is_active' => 1, 'role_id' => 4],
            ['name' => 'Tutus Agustyn Rafzhanyani', 'username' => 'tutus', 'password' => bcrypt('tutus987'), 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Lina Dwi Ulfa', 'username' => 'lina', 'password' => bcrypt('lina987'), 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Achmad Zauzi Rifqi', 'username' => 'zauzi', 'password' => bcrypt('zauzi987'), 'is_active' => 1, 'role_id' => 5],
            ['name' => 'Risky Anggara', 'username' => 'risky', 'password' => bcrypt('risky987'), 'is_active' => 1, 'role_id' => 6],
            ['name' => 'Nico Aldy Dwi Putra', 'username' => 'nico', 'password' => bcrypt('nico987'), 'is_active' => 1, 'role_id' => 6],
            ['name' => 'Dwi Wahyu Nugroho', 'username' => 'dwi', 'password' => bcrypt('dwi987'), 'is_active' => 1, 'role_id' => 6],
            ['name' => 'Fery Ardhianto', 'username' => 'fery', 'password' => bcrypt('fery987'), 'is_active' => 1, 'role_id' => 8],
            ['name' => 'Rangga Wisnu Wardhana', 'username' => 'rangga', 'password' => bcrypt('rangga987'), 'is_active' => 1, 'role_id' => 8],
            ['name' => 'Dita Putri Pertiwi', 'username' => 'dita', 'password' => bcrypt('dita987'), 'is_active' => 1, 'role_id' => 8],
        ]);

        Station::insert([
            ['name' => 'Gilingan'],
            ['name' => 'Pemurnian'],
            ['name' => 'Penguapan'],
            ['name' => 'DRK'],
            ['name' => 'Masakan'],
            ['name' => 'Stroop'],
            ['name' => 'Gula'],
            ['name' => 'Tangki Tetes'],
            ['name' => 'Ketel'],
            ['name' => 'Packer'],
            ['name' => 'Request'],
            ['name' => 'Sogokan'],
        ]);

        Unit::insert([
            ['name' => '%'],
            ['name' => '°Z'],
            ['name' => '°C'],
            ['name' => 'IU'],
            ['name' => 'MCU'],
            ['name' => 'pH'],
            ['name' => 'Ku'],
            ['name' => 'm3/H'],
            ['name' => 'm3'],
        ]);

        Parameter::insert([
            ['name' => 'Brix', 'unit_id' => 1],
            ['name' => 'Pol', 'unit_id' => 1],
            ['name' => 'Pol_baca', 'unit_id' => 2],
            ['name' => 'HK', 'unit_id' => 1],
            ['name' => 'R', 'unit_id' => 1],
            ['name' => 'IU', 'unit_id' => 4],
            ['name' => 'MC', 'unit_id' => 1],
            ['name' => 'ZK', 'unit_id' => 1],
        ]);

        MonitoringHourlySpot::insert([
            ['name' => 'Tebu Tergiling', 'unit_id' => 7],
            ['name' => 'Totalizer NMP', 'unit_id' => 9],
            ['name' => 'Totalizer NMG', 'unit_id' => 9],
            ['name' => 'Totalizer IMB', 'unit_id' => 9],
            ['name' => 'Flow NMP', 'unit_id' => 8],
            ['name' => 'Flow NMG', 'unit_id' => 8],
            ['name' => 'Flow IMB', 'unit_id' => 8],
            ['name' => 'NMP%Tebu', 'unit_id' => 1],
            ['name' => 'NMG%Tebu', 'unit_id' => 1],
            ['name' => 'IMB%Tebu', 'unit_id' => 1],
        ]);

    }
}
