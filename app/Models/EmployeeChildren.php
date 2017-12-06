<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeChildren extends Model
{
    protected $table = 'employees_children';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'birthDate',
        'employeeId',
        'createdAt'
    ];

}
