<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function dashboardAdmin()
    {
        $totalLaporan = Laporan::count();
        $laporanByStatus = Laporan::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $laporan = Laporan::orderBy('created_at', 'desc')->get();
        
        return view('dashboard.admin', compact('totalLaporan', 'laporanByStatus', 'laporan'));
    }

    public function dashboardWarga()
    {
        $nik = session('nik');
        $totalLaporan = Laporan::where('nik_pelapor', $nik)->count();
        
        $laporanByStatus = Laporan::where('nik_pelapor', $nik)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $laporan = Laporan::where('nik_pelapor', $nik)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.warga', compact('totalLaporan', 'laporanByStatus', 'laporan'));
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'deskripsi' => 'required',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,mov|max:10240',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('laporan', 'public');
            $data['media_path'] = $path; // Simpan path relatif
        }
    
        $data['nik_pelapor'] = session('nik');
        $data['status'] = 'Menunggu';
    
        Laporan::create($data);
    
        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        
        if ($laporan->media_path) {
            $laporan->media_path = Storage::url($laporan->media_path);
        }

        return response()->json($laporan);
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
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function filter($status)
    {
        $query = Laporan::with('warga');
        
        if ($status !== 'semua') {
            $query->where('status', ucfirst($status));
        }

        $laporan = $query->latest()->get();
        
        $html = view('components.laporan-table', [
            'laporan' => $laporan,
            'isAdmin' => session('role') === 'admin'
        ])->render();

        return response()->json(['html' => $html]);
    }
}