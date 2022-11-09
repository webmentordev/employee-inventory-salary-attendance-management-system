<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subunits extends Model
{
    use HasFactory;

    protected $fillable = [
        'units_id',
        'subunit'
    ];

    public function main_unit(){
        return $this->belongsTo(Units::class, 'units_id', 'id');
    }

    public function product(){
        return $this->belongsTo(Products::class);
    }
}