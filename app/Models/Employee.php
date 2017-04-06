<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'cpf',
        'providerId',
        'status'
    ];

    /**
     * Rules of the validation
     *
     * @param null $id
     * @return array
     */
    public function validateRules($id = NULL)
    {
        return [
            'name' => 'required|min:2',
            'cpf' => 'required|unique_multiple:employees,cpf,providerId,id=' . $id,
            'companies' => 'required'
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
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.unique_multiple' => 'Este CPF já foi cadastrado.',
            'companies.required' => 'Selecione pelo menos uma empresa.',
        ];
    }
}
