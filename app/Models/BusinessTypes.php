<?php

namespace App\Models;

use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessTypes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function forBusiness(){
        return $this->hasMany(Business::class, 'business_type_id', 'id');
    }
}
