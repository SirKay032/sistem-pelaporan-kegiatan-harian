<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarian;
use App\Models\LaporanDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAtasan()) {
            return $this->indexAtasan();
        } else {
            return $this->indexPegawai();
        }
    }

    private function indexPegawai()
    {
        $user = Auth::user();
        $laporan = LaporanHarian::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('laporan.index', compact('laporan'));
    }

    private function indexAtasan()
    {
        $user = Auth::user();
        $bawahan = User::where('atasan_id', $user->id)->pluck('id')->toArray();

        $laporan = LaporanHarian::whereIn('user_id', $bawahan)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('laporan.atasan', compact('laporan'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kegiatan' => 'required|string',
            'target' => 'nullable|string',
            'hasil' => 'nullable|string',
        ]);

        $laporan = LaporanHarian::create([
            'user_id' => $user->id,
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => 'submitted',
        ]);

        $kegiatanList = preg_split('/\r\n|\r|\n/', $request->kegiatan);

        foreach ($kegiatanList as $kegiatan) {
            $kegiatan = trim($kegiatan);
            if ($kegiatan === '') {
                continue;
            }

            LaporanDetail::create([
                'laporan_id' => $laporan->id,
                'kegiatan' => $kegiatan,
                'target' => $request->target,
                'hasil' => $request->hasil,
            ]);
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dikirim.');
    }

    public function show(LaporanHarian $laporan)
    {
        $user = Auth::user();

        if ($user->id !== $laporan->user_id && $user->id !== $laporan->user->atasan_id && !$user->isAdmin()) {
            abort(403);
        }

        return view('laporan.show', compact('laporan'));
    }

    public function approve(Request $request, LaporanHarian $laporan)
    {
        $user = Auth::user();

        if (!$user->isAtasan() && !$user->isAdmin()) {
            abort(403);
        }

        $laporan->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
            'catatan_atasan' => $request->catatan_atasan,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil disetujui.');
    }

    public function reject(Request $request, LaporanHarian $laporan)
    {
        $user = Auth::user();

        if (!$user->isAtasan() && !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'catatan_atasan' => 'required|string',
        ]);

        $laporan->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
            'catatan_atasan' => $request->catatan_atasan,
        ]);

        return redirect()->back()->with('success', 'Laporan ditolak.');
    }
}
