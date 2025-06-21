<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sumber extends Model
{
    use HasFactory;

    protected $fillable = ['nama_sumber', 'branch_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function wakifs()
    {
        return $this->hasMany(Wakif::class);
    }
}
