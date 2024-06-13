<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $title = "User";
        $data = User::whereNot('id', Auth::user()->id)->latest()->get();
        $fakultas = Fakultas::get();

        return view('modul.user.index', compact('title', 'data', 'fakultas'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "role" => $request->role,
                "fakultas_id" => $request->fakultas_id,
            ];

            $id = $request->id;

            if ($id != null) {
                $user = User::find($id);
                if (empty($user)) {
                    throw new \Exception("User tidak ditemukan");
                }

                if (!$user->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data user");
                }
            } else {
                $user = User::create($data);
                if (!$user->save()) {
                    throw new \Exception("Gagal menambahkan data user");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data user");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::find($request->id);
            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data user");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data user");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function show($id = null)
    {
        $data = User::find($id);
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

    public function profile()
    {
        $title = "Profile";

        return view('modul.user.profile', compact("title"));
    }

    public function gantiPassword(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $checkOldPassword = Hash::check($request->old_password, $user->password);
            if (!$checkOldPassword) {
                throw new \Exception("Password lama salah");
            }

            if ($request->new_password != $request->konfirmasi_password) {
                throw new \Exception("Password baru dan konfirmasi password harus sama");
            }

            $user->password = Hash::make($request->new_password);

            if (!$user->update()) {
                throw new \Exception("Terjadi kesalahan saat memperbarui password");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil memperbarui password");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
