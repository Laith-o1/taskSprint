<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable

{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    protected $guard = 'employee';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'password',
        'address',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    function department()
    {
        return $this->belongsTo(Department::class);
    }
    function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }
    function tasks(){
        return $this->belongsToMany(Task::class);
    
    }
}
