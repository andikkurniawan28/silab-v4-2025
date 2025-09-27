<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Analysis;
use App\Models\Material;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function data()
    {
        $timerange['pagi'] = $this->getShiftTimeRange(1);
        $timerange['sore'] = $this->getShiftTimeRange(2);
        $timerange['malam'] = $this->getShiftTimeRange(3);
        $timerange['harian'] = $this->getShiftTimeRange(4);

        $data['analisa_belum_terverifikasi'] = Analysis::where('is_verified', 0)->count('id');
        $data['material_baru_bulan_ini'] = Material::whereMonth('created_at', date('m'))->count('id') ?? 0;
        $data['stok_form_a'] = Item::find(1)?->saldo() ?? 0;
        $data['stok_form_b'] = Item::find(2)?->saldo() ?? 0;
        $data['stok_kertas_merang'] = Item::find(5)?->saldo() ?? 0;
        $data['npp_pagi'] = [
            'jumlah' => Analysis::where('material_id', 1)->whereBetween('created_at', [$timerange['pagi']['start'], $timerange['pagi']['end']])->count('id'),
            'rendemen' => Analysis::where('material_id', 1)->whereBetween('created_at', [$timerange['pagi']['start'], $timerange['pagi']['end']])->where('is_verified', 1)->avg('p5'),
        ];
        $data['npp_sore'] = [
            'jumlah' => Analysis::where('material_id', 1)->whereBetween('created_at', [$timerange['sore']['start'], $timerange['sore']['end']])->count('id'),
            'rendemen' => Analysis::where('material_id', 1)->whereBetween('created_at', [$timerange['sore']['start'], $timerange['sore']['end']])->where('is_verified', 1)->avg('p5'),
        ];
        $data['npp_malam'] = [
            'jumlah' => Analysis::where('material_id', 1)->whereBetween('created_at', [$timerange['malam']['start'], $timerange['malam']['end']])->count('id'),
            'rendemen' => Analysis::where('material_id', 1)->whereBetween('created_at', [$timerange['malam']['start'], $timerange['malam']['end']])->where('is_verified', 1)->avg('p5'),
        ];
        $data['npp_harian'] = [
            'jumlah' => Analysis::where('material_id', 1)->whereBetween('created_at', [$timerange['harian']['start'], $timerange['harian']['end']])->count('id'),
            'rendemen' => Analysis::where('material_id', 1)->whereBetween('created_at', [$timerange['harian']['start'], $timerange['harian']['end']])->where('is_verified', 1)->avg('p5'),
        ];
        return response()->json($data);
    }

    /**
     * Function 1: Mendapatkan range waktu shift berdasarkan kode shift
     * @param int $shiftCode 1=Pagi, 2=Sore, 3=Malam, 4=Harian
     * @param Carbon|null $date Tanggal referensi (optional, default hari ini)
     * @return array
     */
    public function getShiftTimeRange(int $shiftCode, Carbon $date = null)
    {
        $date = $date ?: Carbon::now();
        $currentHour = $date->hour;

        // Tentukan base date berdasarkan aturan laporan harian (06:00)
        if ($currentHour >= 6) {
            $baseDate = $date->copy()->setTime(0, 0, 0); // Masih tanggal hari ini
        } else {
            $baseDate = $date->copy()->subDay()->setTime(0, 0, 0); // Sudah tanggal kemarin
        }

        switch ($shiftCode) {
            case 1: // Shift Pagi (05:00 - 12:59)
                return [
                    'shift' => 'pagi',
                    'shift_code' => 1,
                    'start' => $baseDate->copy()->setTime(5, 0, 0)->format('Y-m-d H:i:s'),
                    'end' => $baseDate->copy()->setTime(12, 59, 59)->format('Y-m-d H:i:s'),
                    'label' => 'Shift Pagi (05:00 - 12:59)'
                ];

            case 2: // Shift Sore (13:00 - 20:59)
                return [
                    'shift' => 'sore',
                    'shift_code' => 2,
                    'start' => $baseDate->copy()->setTime(13, 0, 0)->format('Y-m-d H:i:s'),
                    'end' => $baseDate->copy()->setTime(20, 59, 59)->format('Y-m-d H:i:s'),
                    'label' => 'Shift Sore (13:00 - 20:59)'
                ];

            case 3: // Shift Malam (21:00 - 04:59) - melewati tengah malam
                return [
                    'shift' => 'malam',
                    'shift_code' => 3,
                    'start' => $baseDate->copy()->setTime(21, 0, 0)->format('Y-m-d H:i:s'),
                    'end' => $baseDate->copy()->addDay()->setTime(4, 59, 59)->format('Y-m-d H:i:s'),
                    'label' => 'Shift Malam (21:00 - 04:59)'
                ];

            case 4: // Laporan Harian (06:00 - 05:59)
                return [
                    'shift' => 'harian',
                    'shift_code' => 4,
                    'start' => $baseDate->copy()->setTime(6, 0, 0)->format('Y-m-d H:i:s'),
                    'end' => $baseDate->copy()->addDay()->setTime(5, 59, 59)->format('Y-m-d H:i:s'),
                    'label' => 'Laporan Harian (06:00 - 05:59)'
                ];

            default:
                throw new \InvalidArgumentException("Kode shift tidak valid. Gunakan: 1=Pagi, 2=Sore, 3=Malam, 4=Harian");
        }
    }

    /**
     * Function 2: Menentukan tanggal shift untuk waktu saat ini
     * @param Carbon|null $datetime Waktu yang akan dicek (optional, default sekarang)
     * @return array
     */
    public function getCurrentShiftDate(Carbon $datetime = null)
    {
        $datetime = $datetime ?: Carbon::now();
        $currentHour = $datetime->hour;
        $currentMinute = $datetime->minute;

        // Tentukan shift saat ini
        if ($currentHour >= 5 && $currentHour < 13) {
            $currentShift = 1; // Pagi
        } elseif ($currentHour >= 13 && $currentHour < 21) {
            $currentShift = 2; // Sore
        } else {
            $currentShift = 3; // Malam
        }

        // Tentukan tanggal shift berdasarkan aturan laporan harian (06:00)
        if ($currentHour >= 6) {
            // Setelah jam 06:00, masih tanggal hari ini untuk semua shift
            $shiftDate = $datetime->copy()->setTime(0, 0, 0);
            $isYesterday = false;
        } else {
            // Sebelum jam 06:00, masih tanggal kemarin untuk semua shift
            $shiftDate = $datetime->copy()->subDay()->setTime(0, 0, 0);
            $isYesterday = true;
        }

        return [
            'current_datetime' => $datetime->format('Y-m-d H:i:s'),
            'current_shift' => $currentShift,
            'shift_date' => $shiftDate->format('Y-m-d'),
            'is_yesterday' => $isYesterday,
            'shift_label' => $this->getShiftLabel($currentShift),
            'message' => $isYesterday ?
                "Masih menggunakan tanggal shift kemarin ({$shiftDate->format('d/m/Y')})" :
                "Menggunakan tanggal shift hari ini ({$shiftDate->format('d/m/Y')})"
        ];
    }
}
