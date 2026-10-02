<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Laporan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute untuk Login & Register Pengguna (Flutter)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::put('/pengguna/{idPengguna}/profil', function (Request $request, int $idPengguna) {
    $pengguna = User::where('role', '!=', 'admin')->findOrFail($idPengguna);
    abort_if(!$pengguna->is_active, 403, 'Akun pengguna sedang dinonaktifkan.');

    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:user,email,' . $pengguna->id],
        'no_hp' => ['nullable', 'string', 'min:10', 'max:13', 'unique:user,no_hp,' . $pengguna->id],
    ]);

    $pengguna->update($data);

    return response()->json([
        'status' => 'success',
        'message' => 'Profil berhasil diperbarui.',
        'data' => $pengguna->only(['id', 'name', 'email', 'no_hp']),
    ]);
});

Route::put('/pengguna/{idPengguna}/password', function (Request $request, int $idPengguna) {
    $pengguna = User::where('role', '!=', 'admin')->findOrFail($idPengguna);
    abort_if(!$pengguna->is_active, 403, 'Akun pengguna sedang dinonaktifkan.');

    $data = $request->validate([
        'password_lama' => ['required', 'string'],
        'password_baru' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    if (!Hash::check($data['password_lama'], $pengguna->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Password lama tidak sesuai.',
        ], 422);
    }

    $pengguna->password = Hash::make($data['password_baru']);
    $pengguna->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Password berhasil diperbarui.',
    ]);
});

// Rute untuk Pengiriman Laporan
Route::post('/lapor', function (Request $request) {
    $idPengguna = $request->input('id_pengguna', 1);
    $pengguna = User::find($idPengguna);
    if (!$pengguna || !$pengguna->is_active) {
        return response()->json([
            'status' => 'error',
            'message' => 'Akun tidak aktif atau tidak ditemukan.',
        ], 403);
    }

    $laporanTerakhir = Laporan::where('id_pengguna', $idPengguna)
        ->latest('created_at')
        ->first();

    if ($laporanTerakhir && $laporanTerakhir->status_penanganan !== 'Selesai') {
        return response()->json([
            'status' => 'error',
            'message' => 'Laporan baru hanya dapat dibuat setelah laporan terakhir selesai ditangani.',
        ], 422);
    }

    if ($laporanTerakhir && $laporanTerakhir->completed_at) {
        $waktuBisaMelapor = $laporanTerakhir->completed_at->copy()->addDays(2);
        if (now()->lt($waktuBisaMelapor)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan baru dapat dibuat 2 hari setelah laporan terakhir selesai, yaitu ' . $waktuBisaMelapor->format('d-m-Y H:i') . '.',
                'bisa_kirim_pada' => $waktuBisaMelapor->toIso8601String(),
            ], 429);
        }
    }

    $request->validate([
        'bukti_lampiran' => ['required', 'array', 'min:1', 'max:3'],
        'bukti_lampiran.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
    ]);

    $tanggal = $request->tanggal_kejadian;
    if ($tanggal) {
        try {
            if (str_contains($tanggal, '-')) {
                $parts = explode('-', $tanggal);
                if (strlen($parts[0]) == 2) {
                    $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
                }
            }
        } catch (\Exception $e) {
            $tanggal = now()->format('Y-m-d');
        }
    } else {
        $tanggal = now()->format('Y-m-d');
    }

    $nomorLaporan = 'LAP-' . date('Ymd') . '-' . rand(100, 999);
    $lampiranPaths = collect($request->file('bukti_lampiran'))
        ->map(fn ($file) => $file->store('bukti-laporan', 'public'))
        ->all();

    $laporan = Laporan::create([
        'nomor_laporan'     => $nomorLaporan,
        'id_pengguna'       => $idPengguna,
        'kategori'          => $request->kategori,
        'sebagai'           => $request->sebagai,
        'nama_pelapor'      => $request->nama_pelapor ?? $request->pelapor_nama ?? 'Revitaaa',
        'lokasi_kejadian'   => $request->lokasi_kejadian ?? $request->lokasi,
        'tanggal_kejadian'  => $tanggal,
        'kronologi'         => $request->kronologi,
        'bukti_lampiran'    => implode(', ', $lampiranPaths),
        'status_penanganan' => 'Menunggu Verifikasi',
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Laporan berhasil terkirim ke Admin!',
        'data'    => $laporan,
    ], 201);
});

Route::get('/notifikasi/{idPengguna}', function (int $idPengguna) {
    $notifikasi = Laporan::query()
        ->where('id_pengguna', $idPengguna)
        ->whereNotNull('catatan_admin')
        ->where('catatan_admin', '!=', '')
        ->whereNotExists(function ($query) use ($idPengguna) {
            $query->selectRaw('1')
                ->from('notifikasi_dihapus')
                ->whereColumn('notifikasi_dihapus.id_laporan', 'laporan.id_laporan')
                ->whereColumn('notifikasi_dihapus.laporan_updated_at', 'laporan.updated_at')
                ->where('notifikasi_dihapus.id_pengguna', $idPengguna);
        })
        ->latest('updated_at')
        ->get([
            'id_laporan',
            'nomor_laporan',
            'status_penanganan',
            'catatan_admin',
            'updated_at',
        ]);

    return response()->json([
        'status' => 'success',
        'data' => $notifikasi,
    ]);
});

Route::delete('/notifikasi/{idPengguna}/{idLaporan}', function (int $idPengguna, int $idLaporan) {
    $laporan = Laporan::where('id_pengguna', $idPengguna)->findOrFail($idLaporan);

    DB::table('notifikasi_dihapus')->updateOrInsert(
        [
            'id_pengguna' => $idPengguna,
            'id_laporan' => $idLaporan,
        ],
        [
            'laporan_updated_at' => $laporan->updated_at,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    );

    return response()->json([
        'status' => 'success',
        'message' => 'Notifikasi berhasil dihapus.',
    ]);
});