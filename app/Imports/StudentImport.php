<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Tambahkan ini

class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan NIS unik, jika ada update, jika tidak buat baru
        return Student::updateOrCreate(
            ['nis' => $row['nis']], // Kunci pencarian (Cek NIS)
            [
                'name'       => $row['nama_siswa'], // Sesuaikan dengan header Excel
                'class_name' => $row['kelas'],
            ]
        );
    }
}
