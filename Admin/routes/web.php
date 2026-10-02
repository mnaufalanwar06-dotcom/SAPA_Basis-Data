<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Hash;

// ========================================================
// Autentikasi Admin (Login & Logout)
// ========================================================
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');

// ========================================================
// Web Admin Dashboard & Manajemen (Wajib Login Admin)
// ========================================================
Route::middleware('auth')->group(function () {
    // Dashboard & Laporan
    Route::get('/', [LaporanController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::put('/laporan/{id}/status', [LaporanController::class, 'updateStatus'])->name('laporan.update-status');

    // Manajemen Pengguna
    Route::get('/pengguna', function () {
        $penggunas = User::whereRaw('LOWER(role) != ?', ['admin'])
            ->latest()
            ->get();
        return view('pengguna.index', compact('penggunas'));
    })->name('pengguna.index');

    Route::get('/pengguna/login', function () {
        return view('pengguna.login');
    })->name('pengguna.login');

    Route::get('/pengguna/{id}', function ($id) {
        $user = User::findOrFail($id);
        $laporans = Laporan::where('id_pengguna', $id)->latest()->get();
        return view('pengguna.show', compact('user', 'laporans'));
    })->name('pengguna.show');

    Route::post('/pengguna/{id}/status', function ($id) {
        $user = User::findOrFail($id);
        abort_if($user->isAdmin(), 403, 'Status akun admin tidak dapat diubah dari halaman ini.');

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with(
            'success',
            $user->is_active ? 'Akun pengguna berhasil diaktifkan.' : 'Akun pengguna berhasil dinonaktifkan.'
        );
    })->name('pengguna.toggle-status');

    // Pengaturan Akun Admin
    Route::get('/pengaturan', function () {
        $admin = auth()->user();
        return view('pengaturan.index', compact('admin'));
    })->name('pengaturan.index');

    Route::post('/pengaturan/profil', function (Request $request) {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . auth()->id(),
        ], [
            'name.required'  => 'Nama admin wajib diisi.',
            'email.required' => 'Email admin wajib diisi.',
            'email.unique'   => 'Email sudah terdaftar untuk pengguna lain.',
        ]);

        /** @var User $admin */
        $admin = auth()->user();
        $admin->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success_profil', 'Profil admin berhasil diperbarui!');
    })->name('pengaturan.update-profil');

    Route::post('/pengaturan/password', function (Request $request) {
        $request->validate([
            'password_lama'       => 'required',
            'password_baru'       => 'required|string|min:6',
            'konfirmasi_password' => 'required|same:password_baru',
        ], [
            'password_lama.required'       => 'Kata sandi lama wajib diisi.',
            'password_baru.required'       => 'Kata sandi baru wajib diisi.',
            'password_baru.min'            => 'Kata sandi baru minimal 6 karakter.',
            'konfirmasi_password.required' => 'Konfirmasi kata sandi wajib diisi.',
            'konfirmasi_password.same'     => 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.',
        ]);

        /** @var User $admin */
        $admin = auth()->user();

        if (!Hash::check($request->password_lama, $admin->password)) {
            return back()->withErrors([
                'password_lama' => 'Kata sandi lama yang Anda masukkan tidak sesuai.',
            ]);
        }

        $admin->update([
            'password' => $request->password_baru, // di-hash otomatis oleh casting model User
        ]);

        return back()->with('success_password', 'Kata sandi berhasil diperbarui!');
    })->name('pengaturan.update-password');
});

// ========================================================
// API Endpoints untuk Flutter Mobile
// ========================================================
Route::get('/api/laporan-terakhir', function () {
    $laporan = Laporan::latest()->first();

    if (!$laporan) {
        return response()->json([
            'status'  => 'empty',
            'message' => 'Belum ada laporan aktif',
            'data'    => null,
        ], 404);
    }

    return response()->json([
        'status'  => 'success',
        'message' => 'Laporan ditemukan',
        'data'    => $laporan,
    ]);
});

Route::get('/api/riwayat', function (Request $request) {
    $query = Laporan::query();

    if ($request->filled('id_pengguna')) {
        $query->where('id_pengguna', $request->id_pengguna);
    } elseif ($request->filled('nama_pelapor')) {
        $query->where('nama_pelapor', $request->nama_pelapor);
    }

    $laporan = $query->latest()->get();

    return response()->json([
        'status'  => 'success',
        'message' => 'Daftar riwayat laporan berhasil diambil',
        'data'    => $laporan,
    ], 200);
});

Route::put('/api/laporan/{id}', function (Request $request, $id) {
    $laporan = Laporan::where('id_laporan', $id)->first();

    if (!$laporan) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Laporan tidak ditemukan',
        ], 404);
    }

    $tanggal = $request->tanggal_kejadian;
    if ($tanggal && str_contains($tanggal, '-')) {
        $parts = explode('-', $tanggal);
        if (strlen($parts[0]) == 2) {
            try {
                $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
            } catch (\Exception $e) {}
        }
    }

    $laporan->update([
        'kategori'         => $request->kategori ?? $laporan->kategori,
        'lokasi_kejadian'  => $request->lokasi_kejadian ?? $request->lokasi ?? $laporan->lokasi_kejadian,
        'tanggal_kejadian' => $tanggal ?? $laporan->tanggal_kejadian,
        'kronologi'        => $request->kronologi ?? $laporan->kronologi,
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Laporan berhasil diperbarui!',
        'data'    => $laporan,
    ], 200);
});

Route::delete('/api/laporan/{id}', function ($id) {
    $laporan = Laporan::where('id_laporan', $id)->first();

    if ($laporan) {
        $laporan->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'Laporan berhasil dihapus',
        ]);
    }

    return response()->json([
        'status'  => 'error',
        'message' => 'Laporan tidak ditemukan',
    ], 404);
});