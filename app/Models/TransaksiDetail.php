<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $fillable = ['transaksi_id', 'program_id', 'projek_id', 'revenue'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function projek()
    {
        return $this->belongsTo(Projek::class);
    }
}
