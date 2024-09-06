<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = ['name', 'kategori_id', 'price'];
    public $timestamps = true;
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
