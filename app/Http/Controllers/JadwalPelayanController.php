<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\JadwalPelayan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalPelayanController extends Controller
{
    public function index()
    {
        $title = "Jadwal";
        $fakultas = Fakultas::get();
        $data = JadwalPelayan::latest()->get();

        return view('modul.jadwal.index', compact('title', 'fakultas', 'data'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "fakultas_id" => $request->fakultas_id,
                "nama_jadwal" => $request->nama_jadwal,
                "jadwal" => $request->jadwal,
                "jenis_pelayanan" => $request->jenis_pelayanan,
                "status" => "belum_dimulai",
            ];

            $id = $request->id;

            if ($id != null) {
                $jadwal = JadwalPelayan::find($id);
                if (empty($jadwal)) {
                    throw new \Exception("Jadwal tidak ditemukan");
                }

                if (!$jadwal->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data jadwal");
                }
            } else {
                $jadwal = JadwalPelayan::create($data);
                if (!$jadwal->save()) {
                    throw new \Exception("Gagal menambahkan data jadwal");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data jadwal");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function kolekte(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = JadwalPelayan::find($request->id);
            if (empty($data)) {
                throw new \Exception("Jadwal tidak ditemukan");
            }

            $data->kolekte = (int)$request->kolekte;

            if (!$data->update()) {
                throw new \Exception("Gagal menyimpan kolekte");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan kolekte");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = JadwalPelayan::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data jadwal");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data jadwal");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function show($id = null)
    {
        $data = JadwalPelayan::find($id);
        if ($data == null || $id == null) {
            abort(404);
        }

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Terjadi kesalahan: $message"
            ]);
        }
    }

    public function selesai(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = JadwalPelayan::find($request->id);
            $data->status = 'selesai';

            if (!$data->update()) {
                throw new \Exception("Gagal menyelesaikan jadwal");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyelesaikan jadwal");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
