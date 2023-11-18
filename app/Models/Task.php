<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        // name description due_date status
        'name',
        'description',
        'due_date',
        'status',
    ];
    
    function priority()
    {
        return $this->belongsToMany(Priority::class);
    }
    function employee()
    {
        return $this->belongsToMany(Employee::class);
    }
}
