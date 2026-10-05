<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UnitKerja;
use App\Models\LaporanHarian;
use App\Models\LaporanDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create unit kerja
        $unitAdmin = UnitKerja::create([
            'nama_unit' => 'Administrasi',
            'deskripsi' => 'Bagian administrasi dan tata usaha',
        ]);

        $unitOperasional = UnitKerja::create([
            'nama_unit' => 'Operasional',
            'deskripsi' => 'Bagian operasional dan lapangan',
        ]);

        $unitIT = UnitKerja::create([
            'nama_unit' => 'IT & Teknologi',
            'deskripsi' => 'Bagian IT dan infrastruktur',
        ]);

        // Create users
        $admin = User::create([
            'nip' => '00001',
            'nama' => 'Admin Sistem',
            'email' => 'admin@sistem.local',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'unit_id' => $unitAdmin->id,
            'status' => 'aktif',
        ]);

        $atasan1 = User::create([
            'nip' => '00002',
            'nama' => 'Ahmad Wijaya',
            'email' => 'ahmad.wijaya@local',
            'password' => Hash::make('password123'),
            'role' => 'atasan',
            'unit_id' => $unitAdmin->id,
            'status' => 'aktif',
        ]);

        $atasan2 = User::create([
            'nip' => '00003',
            'nama' => 'Rini Rahayu',
            'email' => 'rini.rahayu@local',
            'password' => Hash::make('password123'),
            'role' => 'atasan',
            'unit_id' => $unitOperasional->id,
            'status' => 'aktif',
        ]);

        // Create pegawai
        $pegawai1 = User::create([
            'nip' => '00004',
            'nama' => 'Joko Supriyanto',
            'email' => 'joko.supriyanto@local',
            'password' => Hash::make('password123'),
            'role' => 'pegawai',
            'unit_id' => $unitAdmin->id,
            'atasan_id' => $atasan1->id,
            'status' => 'aktif',
        ]);

        $pegawai2 = User::create([
            'nip' => '00005',
            'nama' => 'Dewi Lestari',
            'email' => 'dewi.lestari@local',
            'password' => Hash::make('password123'),
            'role' => 'pegawai',
            'unit_id' => $unitAdmin->id,
            'atasan_id' => $atasan1->id,
            'status' => 'aktif',
        ]);

        $pegawai3 = User::create([
            'nip' => '00006',
            'nama' => 'Eka Putra Wijaya',
            'email' => 'eka.putra@local',
            'password' => Hash::make('password123'),
            'role' => 'pegawai',
            'unit_id' => $unitOperasional->id,
            'atasan_id' => $atasan2->id,
            'status' => 'aktif',
        ]);

        $pegawai4 = User::create([
            'nip' => '00007',
            'nama' => 'Sinta Megawati',
            'email' => 'sinta.megawati@local',
            'password' => Hash::make('password123'),
            'role' => 'pegawai',
            'unit_id' => $unitOperasional->id,
            'atasan_id' => $atasan2->id,
            'status' => 'aktif',
        ]);

        // Create sample laporan
        $laporan1 = LaporanHarian::create([
            'user_id' => $pegawai1->id,
            'tanggal' => now()->subDays(3),
            'judul' => 'Laporan Kegiatan Administrasi',
            'deskripsi' => 'Kegiatan administrasi rutin',
            'status' => 'approved',
            'approved_by' => $atasan1->id,
            'approved_at' => now(),
        ]);

        LaporanDetail::create([
            'laporan_id' => $laporan1->id,
            'kegiatan' => 'Menyusun dokumen rekap perjalanan dinas',
            'target' => 'Selesai hari ini',
            'hasil' => 'Selesai 100%',
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '11:00',
        ]);

        LaporanDetail::create([
            'laporan_id' => $laporan1->id,
            'kegiatan' => 'Input data ke sistem absensi',
            'target' => 'Selesai hari ini',
            'hasil' => 'Selesai 100%',
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '16:00',
        ]);

        $laporan2 = LaporanHarian::create([
            'user_id' => $pegawai1->id,
            'tanggal' => now()->subDays(2),
            'judul' => 'Laporan Kegiatan Administrasi',
            'deskripsi' => 'Kegiatan administrasi rutin',
            'status' => 'submitted',
        ]);

        LaporanDetail::create([
            'laporan_id' => $laporan2->id,
            'kegiatan' => 'Follow up dokumen yang hilang',
            'target' => 'Selesai hari ini',
            'hasil' => 'Dalam proses',
        ]);

        $laporan3 = LaporanHarian::create([
            'user_id' => $pegawai3->id,
            'tanggal' => now()->subDays(1),
            'judul' => 'Laporan Kegiatan Operasional',
            'deskripsi' => 'Kegiatan operasional lapangan',
            'status' => 'approved',
            'approved_by' => $atasan2->id,
            'approved_at' => now(),
        ]);

        LaporanDetail::create([
            'laporan_id' => $laporan3->id,
            'kegiatan' => 'Monitoring lapangan area kerja',
            'target' => '2 lokasi',
            'hasil' => 'Selesai 100%',
            'waktu_mulai' => '07:00',
            'waktu_selesai' => '15:00',
        ]);
    }
}
