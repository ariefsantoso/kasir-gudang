<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = ['kode', 'name', 'stok'];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
