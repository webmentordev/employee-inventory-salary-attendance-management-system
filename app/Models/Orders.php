<?php

namespace App\Models;

use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_type',
        'customer_name',
        'business_id',
        'customer_id',
        'quantity',
        'total_price',
        'discount'
    ];

    public function product(){
        return $this->belongsTo(Products::class);
    }

    public function business(){
        return $this->belongsTo(Business::class);
    }

    public function invoice(){
        return $this->hasOne(Invoice::class, 'order_id', 'id');
    }
}
