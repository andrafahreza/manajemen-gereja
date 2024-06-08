<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    public function index()
    {
        $title = "Pemgumuman";
        $data = Pengumuman::latest()->get();

        return view('modul.pengumuman.index', compact('title', 'data'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "judul" => $request->judul,
                "isi" => $request->isi,
            ];

            $id = $request->id;

            if ($id != null) {
                $pengumuman = Pengumuman::find($id);
                if (empty($pengumuman)) {
                    throw new \Exception("pengumuman tidak ditemukan");
                }

                if (!$pengumuman->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data pengumuman");
                }
            } else {
                $pengumuman = Pengumuman::create($data);
                if (!$pengumuman->save()) {
                    throw new \Exception("Gagal menambahkan data pengumuman");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data pengumuman");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Pengumuman::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data pengumuman");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data pengumuman");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function show($id = null)
    {
        $data = Pengumuman::find($id);
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
}
