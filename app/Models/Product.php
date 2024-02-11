<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_type',
        'name',
        'price',
        'status'
    ];
    
    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id', 'id');
    }
}
