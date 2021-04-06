<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'quantity',
        'user_id',
        'product_id'
    ];

    // Relacion Uno a muchos Inversa - User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacion Uno a muchos Inversa - Products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
