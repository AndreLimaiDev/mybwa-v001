<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wakif extends Model
{
    use HasFactory;

    protected $fillable = ['nama_wakif', 'hp', 'tgl_dapat', 'wa_status', 'sumber_id', 'prospektor_id', 'status_prospek', 'branch_id'];

    public function sumber()
    {
        return $this->belongsTo(Sumber::class);
    }

    public function prospektor()
    {
        return $this->belongsTo(Karyawan::class, 'prospektor_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
