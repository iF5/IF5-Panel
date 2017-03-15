<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'companies';

    public $timestamps = false;

    protected $fillable = [
        'name', 'cpf'
    ];

    public function validationRules()
    {
        return [
            'name' => 'required|min:2',
            'cpf' => 'required'
        ];
    }
}
