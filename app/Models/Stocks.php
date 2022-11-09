<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_size',
        'products_id',
        'units_id',
        'status',
        'stock_price',
        'price_per_unit',
        'supplier_id',
    ];

    public function stockOfProduct(){
        return $this->belongsTo(Products::class, 'products_id', 'id');
    }

    public function main_unit(){
        return $this->hasOne(Units::class, 'id', 'units_id');
    }

    public function supplier(){
        return $this->hasOne(Suppliers::class, 'id', 'supplier_id');
    }
}