<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama (Revita)
        User::updateOrCreate(
            ['email' => 'revita@gmail.com'],
            [
                'name'          => 'Revita',
                'nik'           => '3509012345670001',
                'tanggal_lahir' => '2000-01-01',
                'alamat'        => 'Jember, Jawa Timur',
                'no_hp'         => '081234567890',
                'role'          => 'admin',
                'password'      => 'admin123', // Otomatis di-hash oleh model User (casts hashed)
            ]
        );

        // 2. Akun Admin SAPA Alternatif (admin@sapa.id)
        User::updateOrCreate(
            ['email' => 'admin@sapa.id'],
            [
                'name'          => 'Administrator SAPA',
                'nik'           => '3509012345670002',
                'tanggal_lahir' => '1995-05-15',
                'alamat'        => 'Pusat Layanan SAPA',
                'no_hp'         => '082198765432',
                'role'          => 'admin',
                'password'      => 'admin123',
            ]
        );
    }
}
