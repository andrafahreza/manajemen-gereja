<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Fakultas;
use App\Models\PetugasIbadah;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakultasController extends Controller
{
    public function index()
    {
        $title = "Fakultas";
        $data = Fakultas::latest()->get();
        $prodi = Prodi::latest()->get();

        return view('modul.fakultas.index', compact('title', 'data', 'prodi'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "prodi_id" => $request->prodi_id,
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

    // Prodi
    public function simpanProdi(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "nama_prodi" => $request->nama_prodi
            ];

            $id = $request->id;
            $check = Prodi::where('nama_prodi', $request->nama_prodi)
            ->where(function($query) use($id) {
                if ($id != null) {
                    $query->where('id', '!=', $id);
                }
            })
            ->first();

            if (!empty($check)) {
                throw new \Exception("Prodi sudah pernah dibuat");
            }

            if ($id != null) {
                $prodi = Prodi::find($id);
                if (empty($prodi)) {
                    throw new \Exception("Prodi tidak ditemukan");
                }

                if (!$prodi->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data prodi");
                }
            } else {
                $prodi = Prodi::create($data);
                if (!$prodi->save()) {
                    throw new \Exception("Gagal menambahkan data prodi");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data prodi");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapusProdi(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Prodi::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data prodi");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data prodi");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function showProdi($id = null)
    {
        $data = Prodi::find($id);
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

    // Petugas
    public function petugas($id = null)
    {
        $title = "Petugas Fakultas";
        $fakultas = Fakultas::find($id);
        if (empty($fakultas)) {
            abort(404);
        }

        $data = PetugasIbadah::where('fakultas_id', $id)->latest()->get();

        return view('modul.fakultas.petugas', compact('title', 'fakultas', 'data'));
    }

    public function simpanPetugas(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "fakultas_id" => $request->fakultas_id,
                "nama" => $request->nama,
                "jabatan" => $request->jabatan,
                "kontak" => $request->kontak,
            ];

            $id = $request->id;

            if ($id != null) {
                $petugas = PetugasIbadah::find($id);
                if (empty($petugas)) {
                    throw new \Exception("Petugas tidak ditemukan");
                }

                if (!$petugas->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data petugas");
                }
            } else {
                $petugas = PetugasIbadah::create($data);
                if (!$petugas->save()) {
                    throw new \Exception("Gagal menambahkan data petugas");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data petugas");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapusPetugas(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = PetugasIbadah::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data petugas");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data fakultas");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function showPetugas($id = null)
    {
        $data = PetugasIbadah::find($id);
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

    // Anggota
    public function anggota($id = null)
    {
        $title = "Anggota";
        $petugas = PetugasIbadah::find($id);
        if (empty($petugas)) {
            abort(404);
        }

        $data = Anggota::where('petugas_id', $id)->latest()->get();

        return view('modul.fakultas.anggota', compact('title', 'petugas', 'data'));
    }

    public function simpanAnggota(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "petugas_id" => $request->petugas_id,
                "nama" => $request->nama,
                "alamat" => $request->alamat,
                "kontak" => $request->kontak,
            ];

            $id = $request->id;

            if ($id != null) {
                $anggota = Anggota::find($id);
                if (empty($anggota)) {
                    throw new \Exception("Anggota tidak ditemukan");
                }

                if (!$anggota->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data anggota");
                }
            } else {
                $anggota = Anggota::create($data);
                if (!$anggota->save()) {
                    throw new \Exception("Gagal menambahkan data anggota");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data anggota");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapusAnggota(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Anggota::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data anggota");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data fakultas");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function showAnggota($id = null)
    {
        $data = Anggota::find($id);
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
