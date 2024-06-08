<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\JadwalPelayan;
use App\Models\PetugasIbadah;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Home";
        $fakultas = Fakultas::get();
        $jadwalTerdekat = JadwalPelayan::where('status', 'belum_dimulai')
        ->orderBy('jadwal')
        ->first();

        $fakultasTerdekat = null;
        $petugas = null;
        if (!empty($jadwalTerdekat)) {
            $fakultasTerdekat = $jadwalTerdekat->fakultas_id;
            $petugas = PetugasIbadah::where('fakultas_id', $jadwalTerdekat->fakultas_id)->get();
        }

        $data = array();
        foreach ($fakultas as $key => $value) {
            $jadwal = JadwalPelayan::where('fakultas_id', $value->id)
            ->where('status', 'belum_dimulai')
            ->orderBy('jadwal')
            ->first();

            $data[] = [
                "fakultas" => $value,
                "jadwal" => $jadwal,
                "terdekat" => $fakultasTerdekat == $value->id ? true : false,
                "css" => $fakultasTerdekat == $value->id ? "card-tale" : "card-light-danger",
                "jadwal" => $jadwal != null ? $this->formatDate($jadwal->jadwal) : "Belum ada Jadwal",
                "kegiatan" => $jadwal != null ? "$jadwal->nama_jadwal" : null
            ];
        }

        return view('front.index', compact('title', 'data', 'jadwalTerdekat', 'petugas'));
    }
}
