<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['wakif_id', 'petugas_id', 'tgl_transaksi', 'jenis_transaksi', 'branch_id'];

    public function wakif()
    {
        return $this->belongsTo(Wakif::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Karyawan::class, 'petugas_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
