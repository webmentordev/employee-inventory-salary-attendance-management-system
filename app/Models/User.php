<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Breaks;
use App\Models\Accounts;
use App\Models\Attendance;
use App\Models\UserSalary;
use App\Http\Livewire\Salary;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'image',
        'phone_number',
        'address',
        'designation_id',
        'work_hours',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function designation(){
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function attendance(){
        return $this->hasOne(Attendance::class)->latestOfMany();
    }

    public function salary(){
        return $this->hasOne(UserSalary::class);
    }

    public function break(){
        return $this->hasMany(Breaks::class)->whereDate('created_at', '=', date('Y-m-d'));
    }

    public function payments(){
        return $this->hasMany(Accounts::class);
    }
}