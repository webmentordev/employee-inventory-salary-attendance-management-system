<?php

namespace App\Models;

use App\Models\UserSalary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'status',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function salary(){
        return $this->hasOne(UserSalary::class, 'user_id', 'user_id');
    }

    public function break(){
        return $this->hasMany(Breaks::class, 'user_id', 'user_id')->latest()->limit(1);
    }
}
