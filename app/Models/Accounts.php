<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'period',
        'salary',
        'status',
        'hours',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
