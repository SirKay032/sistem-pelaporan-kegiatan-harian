<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarian;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isAtasan()) {
            return $this->atasanDashboard();
        } else {
            return $this->pegawaiDashboard();
        }
    }

    private function pegawaiDashboard()
    {
        $user = Auth::user();

        $totalLaporan = LaporanHarian::where('user_id', $user->id)->count();
        $laporanApproved = LaporanHarian::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();
        $laporanSubmitted = LaporanHarian::where('user_id', $user->id)
            ->where('status', 'submitted')
            ->count();

        $recentLaporan = LaporanHarian::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.pegawai', [
            'totalLaporan' => $totalLaporan,
            'laporanApproved' => $laporanApproved,
            'laporanSubmitted' => $laporanSubmitted,
            'recentLaporan' => $recentLaporan,
        ]);
    }

    private function atasanDashboard()
    {
        $user = Auth::user();
        $bawahan = User::where('atasan_id', $user->id)->pluck('id')->toArray();

        $totalBawahan = count($bawahan);
        $laporanMenunggu = LaporanHarian::whereIn('user_id', $bawahan)
            ->where('status', 'submitted')
            ->count();
        $laporanApproved = LaporanHarian::whereIn('user_id', $bawahan)
            ->where('status', 'approved')
            ->count();

        $recentLaporan = LaporanHarian::whereIn('user_id', $bawahan)
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.atasan', [
            'totalBawahan' => $totalBawahan,
            'laporanMenunggu' => $laporanMenunggu,
            'laporanApproved' => $laporanApproved,
            'recentLaporan' => $recentLaporan,
        ]);
    }

    private function adminDashboard()
    {
        $totalPegawai = User::where('role', 'pegawai')->count();
        $totalLaporan = LaporanHarian::count();
        $laporanMenunggu = LaporanHarian::where('status', 'submitted')->count();
        $laporanApproved = LaporanHarian::where('status', 'approved')->count();

        $recentLaporan = LaporanHarian::with('user')
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.admin', [
            'totalPegawai' => $totalPegawai,
            'totalLaporan' => $totalLaporan,
            'laporanMenunggu' => $laporanMenunggu,
            'laporanApproved' => $laporanApproved,
            'recentLaporan' => $recentLaporan,
        ]);
    }
}
