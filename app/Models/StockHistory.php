<?php

namespace App\Models;

use App\Models\Units;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_size',
        'units_id',
        'stock_price',
        'price_per_unit',
        'supplier_id',
    ];

    public function main_unit(){
        return $this->hasOne(Units::class, 'id', 'units_id');
    }
}
