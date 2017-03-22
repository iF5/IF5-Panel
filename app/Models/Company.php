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

    /**
     * Rules of the validation
     *
     * @return array
     */
    public function validateRules()
    {
        return [
            'name' => 'required|min:2',
            'cnpj' => 'required|unique_multiple:companies,cnpj,name'
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
            'cnpj.unique_multiple' => 'O nome e o cnpj da empresa já existe.'
        ];
    }
    
}
