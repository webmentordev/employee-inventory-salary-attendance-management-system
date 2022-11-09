<?php

namespace App\Models;

use App\Models\Catagory;
use App\Models\Subunits;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stocks_id',
        'catagory_id',
        'units_id',
        'price',
        'image',
        'brand_id',
        'barcode'
    ];

    public function catagory(){
        return $this->hasOne(Catagory::class, 'id', 'catagory_id');
    }

    public function subunits(){
        return $this->hasMany(Subunits::class);
    }

    public function stock(){
        return $this->hasOne(Stocks::class)->where('stock_size', '>', 0);
    }

    public function stocks(){
        return $this->hasMany(Stocks::class);
    }

    public function unit(){
        return $this->belongsTo(Subunits::class, 'units_id', 'id');
    }

    public function brand(){
        return $this->belongsTo(Brands::class);
    }
}
