<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Profil User',
            'list' => ['Home', 'Profil']
        ];

        $page = (object) [
            'title' => 'Detail Profil User',
        ];

        $activeMenu = 'profil';

        // Mengambil ID user yang sedang login
        $userId = Auth::id();

        // Ambil data user beserta relasi 'level'
        $user = UserModel::with('level')->find($userId);

        // Jika user tidak ditemukan (kemungkinan sudah logout atau user ID tidak valid)
        if (!$user) {
            return redirect('login')->withErrors(['msg' => 'User tidak ditemukan.']);
        }

        return view('profil.profil_user', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit_foto()
    {
        return view('profil.edit_foto');
    }

    public function update_foto(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

                    // Mengambil ID user yang sedang login
        $userId = Auth::id();

        // Ambil data user beserta relasi 'level'
        $user = UserModel::with('level')->find($userId);

            if ($user) {
                if ($request->hasFile('foto')) {
                    $filename = $user->user_id . '.' . $request->file('foto')->getClientOriginalExtension();
                    // Jika ada file lama dan beda nama, hapus file lama
                    $oldPath = public_path('storage/foto_profil/' . $user->foto);
                    if ($user->foto && $user->foto !== $filename && file_exists($oldPath)) {
                        unlink($oldPath);
                    }

                    // Simpan file baru terlebih dahulu
                    $path = $request->file('foto')->storeAs('public/foto_profil', $filename);

                    $user->foto = $filename;
                    $user->save();
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Foto berhasil diubah',
                    'data' => [
                        'foto' => asset('storage/foto_profil/' . $user->foto)
                    ]
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        return redirect('/profil');
    }
}