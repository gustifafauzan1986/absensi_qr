<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
{
    // Buat User Guru (ID 1)
    // \App\Models\User::factory()->create([
    //     'name' => 'Pak Guru Budi',
    //     'email' => 'guru@sekolah.com',
    //     'password' => bcrypt('password'),
    // ]);

    // $this->call(ClassroomSeeder::class);
    // $this->call(RoleSeeder::class);

    // CONTOH CARA MENGAMBIL ID KELAS DARI SEEDER DI ATAS:
    // Cari kelas yang baru saja dibuat untuk dipakai siswa dummy
    $kelasRPL = \App\Models\Classroom::where('name', 'XII RPL 1')->first();
    // Buat Siswa
    \App\Models\Student::create([
        'id' => Str::uuid(),
        'nis' => '12345', // Scan QR kode "12345" nanti
        'name' => 'Ahmad Siswa',
        'classroom_id' => $kelasRPL->id // Pakai ID dari kelas yang sudah dised
    ]);

    // Buat Jadwal (Sesuaikan jam dengan waktu Anda mengetes sekarang!)
    \App\Models\Schedule::create([
        'id' => Str::uuid(),
        'teacher_id' => '15c0dfbb-2875-4d48-8bbb-5d42f289d803',
        //'teacher_id' => 1,
        'subject_name' => 'Pemrograman Web',
        'day' => 'Sabtu', // Ganti sesuai hari Anda test
        'start_time' => '07:00:00',
        'end_time' => '23:59:00', // Set panjang biar gampang test
    ]);
}
}
