<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'email',
        'mobile_number'
    ];

    public function stocks(){
        return $this->hasMany(Stocks::class, 'supplier_id', 'id');
    }
}
