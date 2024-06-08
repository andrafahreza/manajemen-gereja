<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    public function index()
    {
        $title = "Berita";
        $data = Berita::latest()->get();

        return view('modul.berita.index', compact('title', 'data'));
    }

    public function lihat($id = null)
    {
        $title = "Berita";
        $data = Berita::find($id);
        if (empty($data)) {
            abort(404);
        }

        return view('modul.berita.lihat', compact('title', 'data'));
    }

    public function page($id = null)
    {
        $title = "Berita";
        $data = null;
        if ($id) {
            $data = Berita::find($id);

            if (empty($data)) {
                abort(404);
            }
        }

        return view('modul.berita.simpan', compact('title', 'data'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('berita'), $imageName);

            $data = [
                "gambar" => "berita/$imageName",
                "judul" => $request->judul,
                "isi" => $request->isi
            ];

            $id = $request->id;

            if ($id != null) {
                $berita = Berita::find($id);
                if (empty($berita)) {
                    throw new \Exception("berita tidak ditemukan");
                }

                if (File::exists(public_path($berita->gambar))) {
                    File::delete(public_path($berita->gambar));
                }

                if (!$berita->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data berita");
                }
            } else {
                $berita = Berita::create($data);
                if (!$berita->save()) {
                    throw new \Exception("Gagal menambahkan data berita");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data berita");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Berita::find($request->id);
            if (File::exists(public_path($data->gambar))) {
                File::delete(public_path($data->gambar));
            }

            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data berita");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data berita");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
