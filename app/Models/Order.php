<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $casts = [
        'order_date' => 'datetime',
    ];
    protected $fillable = ['user_id', 'produk_id', 'quantity', 'total_price'];
    public $timestamps = true;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
