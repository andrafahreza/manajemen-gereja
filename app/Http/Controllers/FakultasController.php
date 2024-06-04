<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakultasController extends Controller
{
    public function index()
    {
        $title = "Fakultas";
        $data = Fakultas::latest()->get();

        return view('modul.fakultas.index', compact('title', 'data'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "nama_fakultas" => $request->nama_fakultas
            ];

            $id = $request->id;
            $check = Fakultas::where('nama_fakultas', $request->nama_fakultas)
            ->where(function($query) use($id) {
                if ($id != null) {
                    $query->where('id', '!=', $id);
                }
            })
            ->first();

            if (!empty($check)) {
                throw new \Exception("Fakultas sudah pernah dibuat");
            }

            if ($id != null) {
                $fakultas = Fakultas::find($id);
                if (empty($fakultas)) {
                    throw new \Exception("Fakultas tidak ditemukan");
                }

                if (!$fakultas->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data fakultas");
                }
            } else {
                $fakultas = Fakultas::create($data);
                if (!$fakultas->save()) {
                    throw new \Exception("Gagal menambahkan data fakultas");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data fakultas");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Fakultas::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data fakultas");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data fakultas");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function show($id = null)
    {
        $data = Fakultas::find($id);
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
