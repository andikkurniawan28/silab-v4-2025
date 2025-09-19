<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Factor;
use App\Models\Station;
use App\Models\Material;
use App\Models\Parameter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MonitoringHourlySpot;
use App\Models\ParameterMaterial;
use Illuminate\Support\Facades\Schema;

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
            ['name' => 'Admin QC'],
            ['name' => 'Mandor QC'],
            ['name' => 'KO Pabrikasi'],
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
        Role::whereIn('id',[1,2,3])->update($updateData);

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
            ['name' => 'Air', 'unit_id' => 1],
            ['name' => 'ZK', 'unit_id' => 1],
            ['name' => 'Pol_ampas', 'unit_id' => 1],
            ['name' => 'Pol_ampas2', 'unit_id' => 1], // 10
            ['name' => 'CaO', 'unit_id' => 1],
            ['name' => 'Turbidity', 'unit_id' => 5],
            ['name' => 'pH', 'unit_id' => 6],
            ['name' => 'TDS', 'unit_id' => 1],
            ['name' => 'Sadah', 'unit_id' => 1],
            ['name' => 'P205', 'unit_id' => 1],
            ['name' => 'Silika', 'unit_id' => 1],
            ['name' => 'SO2', 'unit_id' => 1],
            ['name' => 'BJB', 'unit_id' => 1],
            ['name' => 'TSAI', 'unit_id' => 1], // 20
            ['name' => 'Succrose', 'unit_id' => 1],
            ['name' => 'Glucose', 'unit_id' => 1],
            ['name' => 'Fructose', 'unit_id' => 1],
            ['name' => 'Suhu', 'unit_id' => 1],
            ['name' => 'PI', 'unit_id' => 1],
            ['name' => 'Sabut', 'unit_id' => 1],
            ['name' => 'Kapur', 'unit_id' => 1],
            ['name' => 'Fosfat', 'unit_id' => 1],
            ['name' => 'Gured', 'unit_id' => 1],
            ['name' => 'Saccharosa', 'unit_id' => 1], // 30
            ['name' => 'OD', 'unit_id' => 1],
            ['name' => 'Dextran', 'unit_id' => 1],
            ['name' => 'Berat', 'unit_id' => 1],
            ['name' => 'Disp', 'unit_id' => 1],
            ['name' => 'BrixW', 'unit_id' => 1],
            ['name' => 'Ampas', 'unit_id' => 1],
            ['name' => 'CV', 'unit_id' => 1], // 37
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

        $parameters = Parameter::select(['id'])->orderBy('id')->get();
        foreach($parameters as $p){
            $colName = 'p' . $p->id;
            if (!Schema::hasColumn('analyses', $colName)) {
                DB::statement("ALTER TABLE analyses ADD COLUMN `$colName` FLOAT NULL AFTER is_verified");
            }
        }

        Factor::insert([
            ['name' => 'Faktor Rendemen NPP', 'value' => 0.7],
            ['name' => 'Faktor Mellase NPP', 'value' => 0.4],
            ['name' => 'Faktor Analisa Ampas Metode Panas', 'value' => 0.33],
            ['name' => 'Faktor Yodium', 'value' => 0.194059000],
            ['name' => 'Faktor EDTA', 'value' => 0.990099000],
            ['name' => 'Faktor Ayakan 1', 'value' => 4.800000000],
            ['name' => 'Faktor Ayakan 2', 'value' => 7.200000000],
            ['name' => 'Faktor Ayakan 3', 'value' => 10.000000000],
            ['name' => 'Faktor Ayakan 4', 'value' => 14.300000000],
            ['name' => 'Faktor Ayakan 5', 'value' => 25.000000000],
            ['name' => 'Faktor Ayakan 6', 'value' => 50.000000000],
            ['name' => 'Faktor Berat BJB', 'value' => 1.001301692],
        ]);

        Material::insert([
            ['name' => 'Nira Gilingan 1', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Nira Gilingan 2', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Nira Gilingan 3', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Nira Gilingan 4', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Nira Gilingan 5', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Ampas Gilingan 1', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Ampas Gilingan 2', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Ampas Gilingan 3', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Ampas Gilingan 4', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Ampas Gilingan 5', 'station_id' => 1, 'sampling_method' => 'request'],
            ['name' => 'Nira Mentah', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Nira Encer', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Nira Reaction', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Nira Tapis', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Nira Defekasi', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Nira Kotor', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Nira Pre Liming', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 1', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 2', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 3', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 4', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 1', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 2', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 3', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 4', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 1 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 2 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 3 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 4 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Filtrat Decanter 5 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 1 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 2 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 3 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 4 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong Decanter 5 Atas', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong RVF 1', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong RVF 2', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong RVF 3', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Blotong RVF 4', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Kapur Sedar Druju', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Kapur Atmaja Tuban', 'station_id' => 2, 'sampling_method' => 'request'],
            ['name' => 'Nira Kental 1', 'station_id' => 3, 'sampling_method' => 'request'],
            ['name' => 'Nira Kental 2', 'station_id' => 3, 'sampling_method' => 'request'],
            ['name' => 'Lamela In', 'station_id' => 3, 'sampling_method' => 'request'],
            ['name' => 'Lamela Out', 'station_id' => 3, 'sampling_method' => 'request'],
            ['name' => 'Remelter In', 'station_id' => 4, 'sampling_method' => 'request'],
            ['name' => 'Reaction Tank', 'station_id' => 4, 'sampling_method' => 'request'],
            ['name' => 'Carbonated Liquor', 'station_id' => 4, 'sampling_method' => 'request'],
            ['name' => 'Clear Liquor', 'station_id' => 4, 'sampling_method' => 'request'],
            ['name' => 'Sweet Water', 'station_id' => 4, 'sampling_method' => 'request'],
            ['name' => 'Cake Head', 'station_id' => 4, 'sampling_method' => 'request'],
            ['name' => 'Cake Mid', 'station_id' => 4, 'sampling_method' => 'request'],
            ['name' => 'Cake End', 'station_id' => 4, 'sampling_method' => 'request'],
            ['name' => 'Masakan A', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan A Raw', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan C', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan D', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan D2', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan R1', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan R2', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan CVP C', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan CVP D', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Masakan CVP A', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Magma C', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Magma D1', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Magma D2', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Magma RS', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Magma A Raw', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Magma Avinasi', 'station_id' => 5, 'sampling_method' => 'request'],
            ['name' => 'Klare SHS', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'Klare D', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'Stroop A', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'Stroop C', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'R1 Mol', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'R2 Mol', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'Remelter A', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'Remelter CD', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'Tetes Puteran', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'Klare RS', 'station_id' => 6, 'sampling_method' => 'request'],
            ['name' => 'RS In', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'GKP', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula Premium', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula R2', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula A Raw', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula C', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula D1', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula D2', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula RS Produk', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula Periode 1', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula Periode 2', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula Periode 3', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula Periode 4', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula Periode 5', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula Periode 6', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Gula Periode 7', 'station_id' => 7, 'sampling_method' => 'request'],
            ['name' => 'Tetes Tangki 1', 'station_id' => 8, 'sampling_method' => 'request'],
            ['name' => 'Tetes Tangki 2', 'station_id' => 8, 'sampling_method' => 'request'],
            ['name' => 'Tetes Tangki 3', 'station_id' => 8, 'sampling_method' => 'request'],
            ['name' => 'Tetes Tandon', 'station_id' => 8, 'sampling_method' => 'request'],
            ['name' => 'Jiangxin Jianglin', 'station_id' => 9, 'sampling_method' => 'request'],
            ['name' => 'Yoshimine 1', 'station_id' => 9, 'sampling_method' => 'request'],
            ['name' => 'Yoshimine 2', 'station_id' => 9, 'sampling_method' => 'request'],
            ['name' => 'Daert. JJ', 'station_id' => 9, 'sampling_method' => 'request'],
            ['name' => 'Daert. Yoshimine 1', 'station_id' => 9, 'sampling_method' => 'request'],
            ['name' => 'Daert. Yoshimine 2', 'station_id' => 9, 'sampling_method' => 'request'],
            ['name' => 'WTP', 'station_id' => 9, 'sampling_method' => 'request'],
            ['name' => 'HW', 'station_id' => 9, 'sampling_method' => 'request'],
        ]);

        ParameterMaterial::insert([
            ['material_id' => 1, 'parameter_id' => 1], ['material_id' => 1, 'parameter_id' => 2], ['material_id' => 1, 'parameter_id' => 4], ['material_id' => 1, 'parameter_id' => 5], ['material_id' => 1, 'parameter_id' => 6], ['material_id' => 1, 'parameter_id' => 13], ['material_id' => 1, 'parameter_id' => 29], ['material_id' => 1, 'parameter_id' => 30], ['material_id' => 1, 'parameter_id' => 32],
            ['material_id' => 2, 'parameter_id' => 1], ['material_id' => 2, 'parameter_id' => 2], ['material_id' => 2, 'parameter_id' => 4], ['material_id' => 2, 'parameter_id' => 13],
            ['material_id' => 3, 'parameter_id' => 1], ['material_id' => 3, 'parameter_id' => 2], ['material_id' => 3, 'parameter_id' => 4], ['material_id' => 3, 'parameter_id' => 13],
            ['material_id' => 4, 'parameter_id' => 1], ['material_id' => 4, 'parameter_id' => 2], ['material_id' => 4, 'parameter_id' => 4], ['material_id' => 4, 'parameter_id' => 13],
            ['material_id' => 5, 'parameter_id' => 1], ['material_id' => 5, 'parameter_id' => 2], ['material_id' => 5, 'parameter_id' => 4], ['material_id' => 5, 'parameter_id' => 13],
            ['material_id' => 6, 'parameter_id' => 9], ['material_id' => 6, 'parameter_id' => 8], ['material_id' => 6, 'parameter_id' => 7],
            ['material_id' => 7, 'parameter_id' => 9], ['material_id' => 7, 'parameter_id' => 8], ['material_id' => 7, 'parameter_id' => 7],
            ['material_id' => 8, 'parameter_id' => 9], ['material_id' => 8, 'parameter_id' => 8], ['material_id' => 8, 'parameter_id' => 7],
            ['material_id' => 9, 'parameter_id' => 9], ['material_id' => 9, 'parameter_id' => 8], ['material_id' => 9, 'parameter_id' => 7],
            ['material_id' => 10, 'parameter_id' => 9], ['material_id' => 10, 'parameter_id' => 8], ['material_id' => 10, 'parameter_id' => 7], ['material_id' => 10, 'parameter_id' => 10],
            ['material_id' => 11, 'parameter_id' => 1], ['material_id' => 11, 'parameter_id' => 2], ['material_id' => 11, 'parameter_id' => 4], ['material_id' => 11, 'parameter_id' => 5], ['material_id' => 11, 'parameter_id' => 6], ['material_id' => 11, 'parameter_id' => 11], ['material_id' => 11, 'parameter_id' => 12], ['material_id' => 11, 'parameter_id' => 13], ['material_id' => 11, 'parameter_id' => 28], ['material_id' => 11, 'parameter_id' => 29], ['material_id' => 11, 'parameter_id' => 30], ['material_id' => 11, 'parameter_id' => 32],
            ['material_id' => 12, 'parameter_id' => 1], ['material_id' => 12, 'parameter_id' => 2], ['material_id' => 12, 'parameter_id' => 4], ['material_id' => 12, 'parameter_id' => 5], ['material_id' => 12, 'parameter_id' => 6], ['material_id' => 12, 'parameter_id' => 11], ['material_id' => 12, 'parameter_id' => 12], ['material_id' => 12, 'parameter_id' => 13],
            ['material_id' => 13, 'parameter_id' => 1], ['material_id' => 13, 'parameter_id' => 2], ['material_id' => 13, 'parameter_id' => 4], ['material_id' => 13, 'parameter_id' => 5], ['material_id' => 13, 'parameter_id' => 6], ['material_id' => 13, 'parameter_id' => 11], ['material_id' => 13, 'parameter_id' => 12], ['material_id' => 13, 'parameter_id' => 13],
            ['material_id' => 14, 'parameter_id' => 1], ['material_id' => 14, 'parameter_id' => 2], ['material_id' => 14, 'parameter_id' => 4], ['material_id' => 14, 'parameter_id' => 5], ['material_id' => 14, 'parameter_id' => 6], ['material_id' => 14, 'parameter_id' => 11], ['material_id' => 14, 'parameter_id' => 12], ['material_id' => 14, 'parameter_id' => 13],
            ['material_id' => 15, 'parameter_id' => 1], ['material_id' => 15, 'parameter_id' => 2], ['material_id' => 15, 'parameter_id' => 4], ['material_id' => 15, 'parameter_id' => 5], ['material_id' => 15, 'parameter_id' => 6], ['material_id' => 15, 'parameter_id' => 11], ['material_id' => 15, 'parameter_id' => 12], ['material_id' => 15, 'parameter_id' => 13],
            ['material_id' => 16, 'parameter_id' => 1], ['material_id' => 16, 'parameter_id' => 2], ['material_id' => 16, 'parameter_id' => 4], ['material_id' => 16, 'parameter_id' => 5], ['material_id' => 16, 'parameter_id' => 6], ['material_id' => 16, 'parameter_id' => 11], ['material_id' => 16, 'parameter_id' => 12], ['material_id' => 16, 'parameter_id' => 13],
            ['material_id' => 17, 'parameter_id' => 1], ['material_id' => 17, 'parameter_id' => 2], ['material_id' => 17, 'parameter_id' => 4], ['material_id' => 17, 'parameter_id' => 5], ['material_id' => 17, 'parameter_id' => 6], ['material_id' => 17, 'parameter_id' => 11], ['material_id' => 17, 'parameter_id' => 12], ['material_id' => 17, 'parameter_id' => 13],
            ['material_id' => 18, 'parameter_id' => 1], ['material_id' => 18, 'parameter_id' => 2], ['material_id' => 18, 'parameter_id' => 4], ['material_id' => 18, 'parameter_id' => 5], ['material_id' => 18, 'parameter_id' => 6], ['material_id' => 18, 'parameter_id' => 11], ['material_id' => 18, 'parameter_id' => 12], ['material_id' => 18, 'parameter_id' => 13],
            ['material_id' => 19, 'parameter_id' => 1], ['material_id' => 19, 'parameter_id' => 2], ['material_id' => 19, 'parameter_id' => 4], ['material_id' => 19, 'parameter_id' => 5], ['material_id' => 19, 'parameter_id' => 6], ['material_id' => 19, 'parameter_id' => 11], ['material_id' => 19, 'parameter_id' => 12], ['material_id' => 19, 'parameter_id' => 13],
            ['material_id' => 20, 'parameter_id' => 1], ['material_id' => 20, 'parameter_id' => 2], ['material_id' => 20, 'parameter_id' => 4], ['material_id' => 20, 'parameter_id' => 5], ['material_id' => 20, 'parameter_id' => 6], ['material_id' => 20, 'parameter_id' => 11], ['material_id' => 20, 'parameter_id' => 12], ['material_id' => 20, 'parameter_id' => 13],
            ['material_id' => 21, 'parameter_id' => 1], ['material_id' => 21, 'parameter_id' => 2], ['material_id' => 21, 'parameter_id' => 4], ['material_id' => 21, 'parameter_id' => 5], ['material_id' => 21, 'parameter_id' => 6], ['material_id' => 21, 'parameter_id' => 11], ['material_id' => 21, 'parameter_id' => 12], ['material_id' => 21, 'parameter_id' => 13],
            ['material_id' => 26, 'parameter_id' => 1], ['material_id' => 26, 'parameter_id' => 2], ['material_id' => 26, 'parameter_id' => 4], ['material_id' => 26, 'parameter_id' => 5], ['material_id' => 26, 'parameter_id' => 6], ['material_id' => 26, 'parameter_id' => 11], ['material_id' => 26, 'parameter_id' => 12], ['material_id' => 26, 'parameter_id' => 13],
            ['material_id' => 27, 'parameter_id' => 1], ['material_id' => 27, 'parameter_id' => 2], ['material_id' => 27, 'parameter_id' => 4], ['material_id' => 27, 'parameter_id' => 5], ['material_id' => 27, 'parameter_id' => 6], ['material_id' => 27, 'parameter_id' => 11], ['material_id' => 27, 'parameter_id' => 12], ['material_id' => 27, 'parameter_id' => 13],
            ['material_id' => 28, 'parameter_id' => 1], ['material_id' => 28, 'parameter_id' => 2], ['material_id' => 28, 'parameter_id' => 4], ['material_id' => 28, 'parameter_id' => 5], ['material_id' => 28, 'parameter_id' => 6], ['material_id' => 28, 'parameter_id' => 11], ['material_id' => 28, 'parameter_id' => 12], ['material_id' => 28, 'parameter_id' => 13],
            ['material_id' => 29, 'parameter_id' => 1], ['material_id' => 29, 'parameter_id' => 2], ['material_id' => 29, 'parameter_id' => 4], ['material_id' => 29, 'parameter_id' => 5], ['material_id' => 29, 'parameter_id' => 6], ['material_id' => 29, 'parameter_id' => 11], ['material_id' => 29, 'parameter_id' => 12], ['material_id' => 29, 'parameter_id' => 13],
            ['material_id' => 30, 'parameter_id' => 1], ['material_id' => 30, 'parameter_id' => 2], ['material_id' => 30, 'parameter_id' => 4], ['material_id' => 30, 'parameter_id' => 5], ['material_id' => 30, 'parameter_id' => 6], ['material_id' => 30, 'parameter_id' => 11], ['material_id' => 30, 'parameter_id' => 12], ['material_id' => 30, 'parameter_id' => 13],
        ]);

    }
}
