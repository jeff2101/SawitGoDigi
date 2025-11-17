<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'nama' => 'Admin',  // Sesuaikan dengan kolom 'nama' di migration
            'email' => 'admin@gmail.com',
            'no_hp' => null, // Kamu bisa menambahkan nomor HP jika diperlukan
            'alamat' => null, // Kamu bisa menambahkan alamat jika diperlukan
            'password' => bcrypt('123456789'),
            'hak_akses' => 'admin', // Pilih hak akses 'admin' atau 'superadmin'
            'foto' => null, // Foto boleh null jika tidak ingin memasukkan gambar
        ]);
    }
}
