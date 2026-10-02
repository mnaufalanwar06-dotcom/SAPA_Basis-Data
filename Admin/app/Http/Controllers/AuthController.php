<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Fungsi Register (Daftar Akun)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:user,nik',
            'no_hp' => 'required|string|min:10|max:13|unique:user,no_hp',
            'email' => 'required|string|email|max:255|unique:user,email',
            'password' => 'required|string|min:8',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'no_hp.unique' => 'Nomor HP ini sudah terdaftar.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil',
            'data' => $user
        ], 201);
    }

    // Fungsi Login (Masuk Akun)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah!'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun Anda sedang dinonaktifkan. Hubungi admin untuk mengaktifkannya kembali.',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => $user
        ], 200);
    }
}