<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    public $timestamps = false;

    protected $fillable = [
        'name', 'cnpj'
    ];

    public function validationRules()
    {
        return [
            'name' => 'required|min:2',
            'cnpj' => 'required'
        ];
    }
}
