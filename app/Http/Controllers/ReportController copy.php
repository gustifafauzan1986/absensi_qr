<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // 1. Tampilkan Halaman Filter
    public function index()
    {
        return view('report.index');
    }

    // 2. Proses Cetak PDF
    public function print(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Ambil data absensi berdasarkan rentang tanggal
        // Gunakan 'with' (Eager Loading) agar query cepat
        $attendances = Attendance::with(['student', 'schedule'])
                        ->whereBetween('date', [$startDate, $endDate])
                        ->orderBy('date', 'desc')
                        ->get();

        // Load View khusus PDF dan kirim datanya
        $pdf = Pdf::loadView('report.pdf_view', compact('attendances', 'startDate', 'endDate'));
        
        // Set ukuran kertas (A4 Portrait)
        $pdf->setPaper('a4', 'portrait');

        // Stream (Tampilkan di browser) atau Download
        return $pdf->stream('Laporan-Absensi.pdf');
    }
}
