<?php

namespace App\Models;

use App\Models\Customers;
use App\Models\BusinessTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'customer_id',
        'business_type_id',
        'default_discount',
        'is_active'
    ];

    public function type(){
        return $this->hasOne(BusinessTypes::class, 'id', 'business_type_id');
    }

    public function registeredCustomer(){
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }
}