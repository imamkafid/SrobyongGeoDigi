<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $laporan = Laporan::with('warga')->latest()->get();
        $totalLaporan = $laporan->count();
        $laporanByStatus = $laporan->groupBy('status')
            ->map(function ($items) {
                return $items->count();
            });

        return view('dashboard.admin', compact('laporan', 'totalLaporan', 'laporanByStatus'));
    }

    public function warga()
    {
        $laporan = Laporan::with('warga')->latest()->get();
        $totalLaporan = $laporan->count();
        $laporanByStatus = $laporan->groupBy('status')
            ->map(function ($items) {
                return $items->count();
            });

        return view('dashboard.warga', compact('laporan', 'totalLaporan', 'laporanByStatus'));
    }

    public function getLaporanCounts()
    {
        $laporan = Laporan::all();
        return response()->json([
            'total' => $laporan->count(),
            'menunggu' => $laporan->where('status', 'Menunggu')->count(),
            'proses' => $laporan->where('status', 'Proses')->count(),
            'selesai' => $laporan->where('status', 'Selesai')->count(),
            'ditolak' => $laporan->where('status', 'Ditolak')->count(),
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
    try {
        $laporan = Laporan::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui status'
        ], 500);
    }
    }

}