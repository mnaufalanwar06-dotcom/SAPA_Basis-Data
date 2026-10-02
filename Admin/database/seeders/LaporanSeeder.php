<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laporan;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        Laporan::create([
            'nomor_laporan' => 'LAP-2025-0001',
            'kategori' => 'Kekerasan terhadap Perempuan',
            'sebagai' => 'Korban',
            'pelapor_nama' => 'Revitaaa',
            'lokasi' => 'Kabupaten Jember, Jawa Timur',
            'tanggal_kejadian' => '2025-05-12 09:30:00',
            'kronologi' => 'Saya mendapatkan tindakan kekerasan verbal dan intimidasi di lingkungan kerja yang menjurus ke arah kekerasan psikis selama beberapa bulan terakhir.',
            'status' => 'Menunggu Verifikasi',
        ]);

        Laporan::create([
            'nomor_laporan' => 'LAP-2025-0002',
            'kategori' => 'KDRT',
            'sebagai' => 'Saksi',
            'pelapor_nama' => 'Ahmad Wijaya',
            'lokasi' => 'Surabaya',
            'tanggal_kejadian' => '2025-05-11 14:00:00',
            'kronologi' => 'Laporan kejadian KDRT di lingkungan sekitar.',
            'status' => 'Sedang Diproses',
        ]);
    }
}