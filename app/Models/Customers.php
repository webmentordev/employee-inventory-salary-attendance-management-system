<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'city',
        'country',
        'address',
        'business_id',
    ];

    public function registeredBusiness(){
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }
}
