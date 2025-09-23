<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Item;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Factor;
use App\Models\Station;
use App\Models\FlowSpot;
use App\Models\Impurity;
use App\Models\Kawalan;
use App\Models\Material;
use App\Models\Parameter;
use Illuminate\Database\Seeder;
use App\Models\ParameterMaterial;
use Illuminate\Support\Facades\DB;
use App\Models\MonitoringHourlySpot;
use App\Models\MonitoringShiftlySpot;
use App\Models\Variety;
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
            ['name' => 'Mandor Off Farm'],
            ['name' => 'Mandor On Farm'],
            ['name' => 'KO Pabrikasi'],
            ['name' => 'Analis Off Farm'],
            ['name' => 'Analis On Farm'],
            ['name' => 'Operator QC'],
            ['name' => 'Operator Pabrikasi'],
            ['name' => 'Operator Imbibisi'],
            ['name' => 'Operator Masakan'],
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
            ['name' => 'MCU'], // 5
            ['name' => 'pH'],
            ['name' => 'Ku'],
            ['name' => 'm3/H'],
            ['name' => 'm3'],
            ['name' => 'Bar'], // 10
            ['name' => 'Jurigen'],
            ['name' => 'Pack'],
            ['name' => 'Kaleng'],
        ]);

        Item::insert([
            ['name' => 'Form A', 'unit_id' => 11],
            ['name' => 'Form B', 'unit_id' => 11],
            ['name' => 'Kieselguhr', 'unit_id' => 13],
            ['name' => 'Test Kit Ketel', 'unit_id' => 12],
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

        FlowSpot::insert([
            ['name' => 'IMB', 'unit_id' => 8],
            ['name' => 'NMP', 'unit_id' => 8],
            ['name' => 'NMG', 'unit_id' => 8],
            ['name' => 'D1', 'unit_id' => 8],
            ['name' => 'D2', 'unit_id' => 8],
        ]);

        MonitoringHourlySpot::insert([
            ['name' => 'Tekanan Pre Evaporator 1', 'unit_id' => 10],
            ['name' => 'Tekanan Pre Evaporator 2', 'unit_id' => 10],
            ['name' => 'Tekanan Evaporator 1', 'unit_id' => 10],
            ['name' => 'Tekanan Evaporator 2', 'unit_id' => 10],
            ['name' => 'Tekanan Evaporator 3', 'unit_id' => 10],
            ['name' => 'Tekanan Evaporator 4', 'unit_id' => 10],
            ['name' => 'Tekanan Evaporator 5', 'unit_id' => 10],
            ['name' => 'Tekanan Evaporator 6', 'unit_id' => 10],
            ['name' => 'Tekanan Evaporator 7', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 1', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 2', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 3', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 4', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 5', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 6', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 7', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 8', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 9', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 10', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 11', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 12', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 13', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 14', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 15', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 16', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 17', 'unit_id' => 10],
            ['name' => 'Tekanan Pan 18', 'unit_id' => 10],
            ['name' => 'Suhu Pre Evaporator 1', 'unit_id' => 3],
            ['name' => 'Suhu Pre Evaporator 2', 'unit_id' => 3],
            ['name' => 'Suhu Evaporator 1', 'unit_id' => 3],
            ['name' => 'Suhu Evaporator 2', 'unit_id' => 3],
            ['name' => 'Suhu Evaporator 3', 'unit_id' => 3],
            ['name' => 'Suhu Evaporator 4', 'unit_id' => 3],
            ['name' => 'Suhu Evaporator 5', 'unit_id' => 3],
            ['name' => 'Suhu Evaporator 6', 'unit_id' => 3],
            ['name' => 'Suhu Evaporator 7', 'unit_id' => 3],
            ['name' => 'Suhu Heater 1', 'unit_id' => 3],
            ['name' => 'Suhu Heater 2', 'unit_id' => 3],
            ['name' => 'Suhu Heater 3', 'unit_id' => 3],
            ['name' => 'Suhu Air Injeksi', 'unit_id' => 3],
            ['name' => 'Suhu Air Terjun', 'unit_id' => 3],
            ['name' => 'Tekanan Pompa Hampa', 'unit_id' => 10],
            ['name' => 'Tekanan Uap Baru', 'unit_id' => 10],
            ['name' => 'Tekanan Uap Bekas', 'unit_id' => 10],
            ['name' => 'Tekanan Uap 3Ato', 'unit_id' => 10],
            ['name' => 'ph Air Injeksi', 'unit_id' => 10],
            ['name' => 'SFC', 'unit_id' => 8],
        ]);

        $flow_spots = FlowSpot::select(['id'])->orderBy('id')->get();
        foreach ($flow_spots as $fs) {
            $columns = [
                'tb' . $fs->id,
                't' . $fs->id,
                'f' . $fs->id,
                'p' . $fs->id,
            ];
            foreach ($columns as $colName) {
                if (!Schema::hasColumn('flows', $colName)) {
                    DB::statement("ALTER TABLE `flows` ADD COLUMN `$colName` FLOAT NULL AFTER `created_at`");
                }
            }
        }

        $parameters = Parameter::select(['id'])->orderBy('id')->get();
        foreach ($parameters as $p) {
            $colName = 'p' . $p->id;
            if (!Schema::hasColumn('analyses', $colName)) {
                DB::statement("ALTER TABLE analyses ADD COLUMN `$colName` FLOAT NULL AFTER is_verified");
                DB::statement("ALTER TABLE analyses ADD INDEX `idx_$colName` (`$colName`)");
            }
        }

        $monitoring_hourlies = MonitoringHourlySpot::select(['id'])->orderBy('id')->get();
        foreach ($monitoring_hourlies as $mh) {
            $colName = 'p' . $mh->id;
            if (!Schema::hasColumn('monitoring_hourlies', $colName)) {
                DB::statement("ALTER TABLE monitoring_hourlies ADD COLUMN `$colName` FLOAT NULL AFTER updated_at");
                DB::statement("ALTER TABLE monitoring_hourlies ADD INDEX `idx_$colName` (`$colName`)");
            }
        }

        $monitoring_shiftlies = MonitoringShiftlySpot::select(['id'])->orderBy('id')->get();
        foreach ($monitoring_shiftlies as $ms) {
            $colName = 'p' . $ms->id;
            if (!Schema::hasColumn('monitoring_shiftlies', $colName)) {
                DB::statement("ALTER TABLE monitoring_shiftlies ADD COLUMN `$colName` FLOAT NULL AFTER updated_at");
                DB::statement("ALTER TABLE monitoring_shiftlies ADD INDEX `idx_$colName` (`$colName`)");
            }
        }

        Impurity::insert([
            ['name' => 'Daduk'],
            ['name' => 'Akar'],
            ['name' => 'Tali Pucuk'],
            ['name' => 'Pucuk'],
            ['name' => 'Sogolan'],
            ['name' => 'Tebu Muda'],
            ['name' => 'Lelesan'],
            ['name' => 'Terbakar'],
            ['name' => 'Kocor Air'],
            ['name' => 'ATPSD'],
        ]);

        $impurities = Impurity::select(['id'])->orderBy('id')->get();
        foreach ($impurities as $i) {
            $colName = 'p' . $i->id;
            if (!Schema::hasColumn('analisa_on_farms', $colName)) {
                DB::statement("ALTER TABLE analisa_on_farms ADD COLUMN `$colName` TINYINT NULL AFTER updated_at");
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

        Variety::insert([
            ['name' => 'PSKA942'],
            ['name' => 'PS862'],
            ['name' => 'PS881'],
            ['name' => 'PSJK922'],
            ['name' => 'CENING'],
            ['name' => 'PSJT941'],
            ['name' => 'CO617'],
            ['name' => 'PS864'],
            ['name' => 'PS921'],
            ['name' => 'BL'],
            ['name' => 'LAIN2'],
            ['name' => 'BZ132'],
        ]);

        Kawalan::insert([
            ['name' => 'Non VMA'],
            ['name' => 'VMA'],
            ['name' => 'ZPK'],
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
