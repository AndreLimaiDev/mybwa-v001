<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nama_karyawan', 'jabatan_id', 'hp', 'is_active', 'branch_id'];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wakifProspektor()
    {
        return $this->hasMany(Wakif::class, 'prospektor_id');
    }

    public function transaksiPetugas()
    {
        return $this->hasMany(Transaksi::class, 'petugas_id');
    }
}
