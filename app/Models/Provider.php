<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    public $timestamps = false;

    protected $fillable = [
        'name', 'cnpj', 'companyId'
    ];

    public function validationRules()
    {
        return [
            'name' => 'required|min:2',
            'cnpj' => 'required'
        ];
    }
}
