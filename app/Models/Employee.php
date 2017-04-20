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
        'rg',
        'ctps',
        'birthDate',
        'street',
        'district',
        'city',
        'state',
        'jobRole',
        'salaryCap',
        'hiringDate',
        'endingDate',
        'pis',
        'workingHours',
        'workRegime',
        'hasChildren',
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
            'name' => 'required',
            'cpf' => 'required|unique_multiple:employees,cpf,providerId,id=' . $id,
            'rg' => 'required',
            'ctps' => 'required',
            'birthDate' => 'required',
            'street' => 'required',
            'district' => 'required',
            'city' => 'required',
            'state' => 'required',
            'jobRole' => 'required',
            'salaryCap' => 'required',
            'hiringDate' => 'required',
            'pis' => 'required',
            'workingHours' => 'required',
            'workRegime' => 'required',
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
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.unique_multiple' => 'Este CPF já foi cadastrado.',
            'rg' => 'O campo rg é obrigatório.',
            'ctps' => 'O campo ctps é obrigatório.',
            'birthDate' => 'O campo data de nascimento é obrigatório.',
            'street' => 'O campo endereço é obrigatório.',
            'district' => 'O campo bairro é obrigatório.',
            'city' => 'O campo cidade é obrigatório.',
            'state' => 'O campo estado é obrigatório.',
            'jobRole' => 'O campo função é obrigatório.',
            'salaryCap' => 'O campo piso salarial é obrigatório.',
            'hiringDate' => 'O campo data contratação é obrigatório.',
            'pis' => 'O campo número do pis é obrigatório.',
            'workingHours' => 'O campo jornada de trabalho é obrigatório.',
            'workRegime' => 'O campo regime de trabalho é obrigatório.',
            'companies' => 'O campo * é obrigatório.',
            'companies.required' => 'Selecione pelo menos uma empresa.'
        ];
    }
}
