<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'age',
        'email',
        'gender',
        'phone_number',
        'date_of_birth',
        'address',
        'position',
        'department',
        'salary',
    ];
}
