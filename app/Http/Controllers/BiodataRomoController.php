<?php

namespace App\Http\Controllers;

use App\Models\BiodataRomo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BiodataRomoController extends Controller
{
    public function index()
    {
        $title = "Biodata Romo";
        $data = BiodataRomo::latest()->get();

        return view('modul.biodata-romo.index', compact('title', 'data'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('romo'), $imageName);

            $data = [
                "nama" => $request->nama,
                "jabatan" => $request->jabatan,
                "photo" => "romo/$imageName",
                "tanggal_lahir" => $request->tanggal_lahir,
                "keterangan" => $request->keterangan,
            ];

            $id = $request->id;

            if ($id != null) {
                $biodata = BiodataRomo::find($id);
                if (empty($biodata)) {
                    throw new \Exception("biodata tidak ditemukan");
                }

                if (!$biodata->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data biodata");
                }
            } else {
                $biodata = BiodataRomo::create($data);
                if (!$biodata->save()) {
                    throw new \Exception("Gagal menambahkan data biodata");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data jadwal");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = BiodataRomo::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data biodata");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data biodata");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function show($id = null)
    {
        $data = BiodataRomo::find($id);
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
