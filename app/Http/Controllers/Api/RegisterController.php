<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama'     => 'required',
            'password' => 'required',
            'level_id' => 'required|numeric',
            'image'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Upload gambar
        $image = $request->file('image');
        $image->store('images', 'public');

        // Simpan user
        $user = UserModel::create([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => bcrypt($request->password),
            'level_id'  => $request->level_id,
            'image'     => $image->hashName()
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'user'    => $user
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan data user'
        ], 409);
    }
}
