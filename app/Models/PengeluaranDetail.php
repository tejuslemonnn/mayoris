<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class);
    }
}
