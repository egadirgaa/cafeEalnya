<?php

namespace App\Models;

use App\Models\Pesanan;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'total_harga',
        'status',
        'tanggal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }
}
