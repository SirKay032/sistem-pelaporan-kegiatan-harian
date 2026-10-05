@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h2>Dashboard Pegawai</h2>
    <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}</p>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-box">
            <div class="number">{{ $totalLaporan }}</div>
            <div class="label">Total Laporan</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box">
            <div class="number">{{ $laporanApproved }}</div>
            <div class="label">Disetujui</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box">
            <div class="number">{{ $laporanSubmitted }}</div>
            <div class="label">Menunggu Persetujuan</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Laporan Terbaru</h5>
    </div>
    <div class="card-body">
        @if($recentLaporan->isEmpty())
            <p class="text-muted">Belum ada laporan. <a href="{{ route('laporan.create') }}">Buat laporan baru</a></p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentLaporan as $laporan)
                            <tr>
                                <td>{{ $laporan->tanggal->format('d M Y') }}</td>
                                <td>{{ $laporan->judul }}</td>
                                <td>
                                    <span class="badge bg-{{ $laporan->status == 'approved' ? 'success' : ($laporan->status == 'submitted' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('laporan.show', $laporan) }}" class="btn btn-sm btn-primary">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('laporan.create') }}" class="btn btn-primary">Buat Laporan Baru</a>
    <a href="{{ route('rekap.index') }}" class="btn btn-success">Lihat Rekap Bulanan</a>
</div>
@endsection
