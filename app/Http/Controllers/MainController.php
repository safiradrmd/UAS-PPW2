<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;

class MainController extends Controller
{
    public function index() {
        // Data Chart 1: Gender
        $genderData = Pegawai::selectRaw('gender, count(*) as total')
            ->groupBy('gender')
            ->pluck('total', 'gender');
        
        // Format untuk ChartJS: [Total Male, Total Female]
        // Pastikan urutan sesuai label di JS (Male, Female)
        $chartGender = [
            $genderData['male'] ?? 0,
            $genderData['female'] ?? 0
        ];

        // Data Chart 2: Top 5 Pekerjaan
        $pekerjaanData = Pekerjaan::withCount('pegawai')
            ->orderByDesc('pegawai_count')
            ->limit(5)
            ->get();
            
        $labelPekerjaan = $pekerjaanData->pluck('nama');
        $jumlahPegawaiPerPekerjaan = $pekerjaanData->pluck('pegawai_count');

        return view('index', compact('chartGender', 'labelPekerjaan', 'jumlahPegawaiPerPekerjaan'));
    }
}
