<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan_harian')->onDelete('cascade');
            $table->text('kegiatan');
            $table->text('target')->nullable();
            $table->text('hasil')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->string('file_bukti')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_detail');
    }
};
