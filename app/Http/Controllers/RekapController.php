<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarian;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $selectedUser = $request->get('user_id', $user->id);

        if ($user->isPegawai() && $selectedUser != $user->id) {
            abort(403);
        }

        if ($user->isAtasan()) {
            $bawahan = User::where('atasan_id', $user->id)->pluck('id')->toArray();
            if (!in_array($selectedUser, $bawahan) && $selectedUser != $user->id) {
                abort(403);
            }
        }

        $laporan = LaporanHarian::with('detail')
            ->where('user_id', $selectedUser)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status', 'approved')
            ->orderBy('tanggal', 'asc')
            ->get();

        $selectedUserData = User::find($selectedUser);
        $bawahan = $user->isAtasan() ? User::where('atasan_id', $user->id)->get() : collect();

        return view('rekap.index', [
            'laporan' => $laporan,
            'month' => $month,
            'year' => $year,
            'selectedUser' => $selectedUser,
            'selectedUserData' => $selectedUserData,
            'bawahan' => $bawahan,
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $user = Auth::user();
        $userId = $request->get('user_id', $user->id);
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        if ($user->isPegawai() && $userId != $user->id) {
            abort(403);
        }

        if ($user->isAtasan()) {
            $bawahan = User::where('atasan_id', $user->id)->pluck('id')->toArray();
            if (!in_array($userId, $bawahan) && $userId != $user->id) {
                abort(403);
            }
        }

        $laporan = LaporanHarian::with('detail')
            ->where('user_id', $userId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status', 'approved')
            ->orderBy('tanggal', 'asc')
            ->get();

        $userData = User::find($userId);

        $pdf = Pdf::loadView('rekap.pdf', [
            'laporan' => $laporan,
            'user' => $userData,
            'month' => $month,
            'year' => $year,
        ]);

        return $pdf->download('rekap-' . $userId . '-' . $month . '-' . $year . '.pdf');
    }
}
