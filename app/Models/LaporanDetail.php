<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDetail extends Model
{
    use HasFactory;

    protected $table = 'laporan_detail';

    protected $fillable = [
        'laporan_id',
        'kegiatan',
        'target',
        'hasil',
        'waktu_mulai',
        'waktu_selesai',
        'file_bukti',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanHarian::class, 'laporan_id');
    }
}
