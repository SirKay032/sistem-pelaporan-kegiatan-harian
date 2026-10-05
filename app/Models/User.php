<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'password',
        'role',
        'unit_id',
        'atasan_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function laporanHarian()
    {
        return $this->hasMany(LaporanHarian::class, 'user_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_id');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    public function bawahan()
    {
        return $this->hasMany(User::class, 'atasan_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAtasan()
    {
        return $this->role === 'atasan';
    }

    public function isPegawai()
    {
        return $this->role === 'pegawai';
    }
}
