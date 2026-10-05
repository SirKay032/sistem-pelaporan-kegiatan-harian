@extends('layouts.app')

@section('title', 'Dashboard Atasan')

@section('content')
<div class="mb-4">
    <h2>Dashboard Atasan</h2>
    <p class="text-muted">Kelola laporan bawahan Anda</p>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-box">
            <div class="number">{{ $totalBawahan }}</div>
            <div class="label">Total Bawahan</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box">
            <div class="number">{{ $laporanMenunggu }}</div>
            <div class="label">Menunggu Persetujuan</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-box">
            <div class="number">{{ $laporanApproved }}</div>
            <div class="label">Sudah Disetujui</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Laporan Bawahan</h5>
    </div>
    <div class="card-body">
        @if($recentLaporan->isEmpty())
            <p class="text-muted">Tidak ada laporan</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pegawai</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentLaporan as $laporan)
                            <tr>
                                <td>{{ $laporan->tanggal->format('d M Y') }}</td>
                                <td>{{ $laporan->user->nama }}</td>
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
    <a href="{{ route('laporan.index') }}" class="btn btn-primary">Lihat Semua Laporan</a>
</div>
@endsection
