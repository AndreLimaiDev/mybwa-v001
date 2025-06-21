<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name','inisial'];

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }

    public function wakifs()
    {
        return $this->hasMany(Wakif::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function sumbers()
    {
        return $this->hasMany(Sumber::class);
    }

    public function anggotas(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
