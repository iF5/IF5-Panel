<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    public $timestamps = false;

    protected $fillable = [
        'name', 'cnpj'
    ];

    /**
     * Rules of the validation
     *
     * @return array
     */
    public function validateRules()
    {
        return [
            'name' => 'required|min:2',
            'cnpj' => 'required|unique:providers'
        ];
    }

    /**
     * Messages of the validation
     *
     * @return array
     */
    public function validateMessages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O campo nome deve ter no mínimo 2 caracteres.',
            'cnpj.required' => 'O campo cnpj é obrigatório.',
            'cnpj.unique' => 'Esse CNPJ já existe.'
        ];
    }

}
