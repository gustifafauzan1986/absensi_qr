<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Menampilkan Halaman Scanner
    public function index($schedule_id)
    {
        // Cari jadwal berdasarkan ID, pastikan milik guru yang login
        $schedule = Schedule::where('id', $schedule_id)
                    ->where('teacher_id', Auth::id())
                    ->firstOrFail();

        // Kirim data jadwal ke view scan
        return view('scan', compact('schedule'));
    }

    // Proses Simpan Data Absensi (AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'schedule_id' => 'required|exists:schedules,id'
        ]);

        // 1. Cari Siswa Berdasarkan NIS
        $student = Student::where('nis', $request->nis)->first();
        if (!$student) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Siswa dengan NIS tersebut tidak ditemukan!'
            ]);
        }

        // 2. Validasi Jadwal (Pastikan jadwal ini milik guru yang sedang login)
        $schedule = Schedule::where('id', $request->schedule_id)
                    ->where('teacher_id', Auth::id())
                    ->first();

        if (!$schedule) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Jadwal tidak valid atau bukan milik Anda!'
            ]);
        }

        // ---------------------------------------------------------
        // 3. VALIDASI KELAS (LOGIKA BARU)
        // Cek apakah kelas siswa SAMA dengan kelas di jadwal?
        // ---------------------------------------------------------
        if ($student->class_name !== $schedule->class_name) {
            return response()->json([
                'status' => 'error',
                'message' => "SALAH KELAS! Siswa {$student->name} adalah siswa kelas {$student->class_name}, sedangkan ini jadwal kelas {$schedule->class_name}."
            ]);
        }

        // 4. Cek Duplikasi (Apakah siswa sudah absen hari ini di mapel ini?)
        $existing = Attendance::where('student_id', $student->id)
                    ->where('schedule_id', $schedule->id) // Cek spesifik ID jadwal
                    ->where('date', date('Y-m-d'))
                    ->first();

        if ($existing) {
            return response()->json([
                'status' => 'error', 
                'message' => "Siswa {$student->name} sudah melakukan absensi sebelumnya!"
            ]);
        }

        // 5. Simpan Kehadiran
        // Cek keterlambatan (Opsional: toleransi 15 menit)
        $status = 'hadir';
        $jamMasuk = Carbon::parse($schedule->start_time);
        $jamSekarang = Carbon::now();
        
        // Jika lewat 15 menit dari jam masuk, anggap terlambat
        if ($jamSekarang->greaterThan($jamMasuk->addMinutes(15))) {
            $status = 'terlambat';
        }

        Attendance::create([
            'student_id' => $student->id,
            'schedule_id' => $schedule->id,
            'date' => date('Y-m-d'),
            'check_in_time' => date('H:i:s'),
            'status' => $status
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Absensi Berhasil Dicatat', 
            'student' => $student->name . " (" . strtoupper($status) . ")"
        ]);
    }
}