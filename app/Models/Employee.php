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
        'cep',
        'street',
        'number',
        'district',
        'city',
        'state',
        'jobRole',
        'salaryCap',
        'hiringDate',
        'pis',
        'workingHours',
        'workRegime',
        'hasChildren',
        'layOff',
        'removalDate',
        'daysRemoval',
        'dismissalDate',
        'providerId',
        'status',
        'startAt',
        'createdAt',
        'updatedAt'
    ];

    /**
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Rules of the validation
     *
     * @param null $id
     * @return array
     */
    public function rules($id = NULL)
    {
        return [
            'name' => 'required',
            'cpf' => 'required|unique_multiple:employees,cpf,providerId,id=' . $id,
            'rg' => 'required',
            'ctps' => 'required',
            'birthDate' => 'required',
            'cep' => 'required',
            'street' => 'required',
            'number' => 'required',
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
    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.unique_multiple' => 'Este CPF já foi cadastrado.',
            'rg' => 'O campo rg é obrigatório.',
            'ctps' => 'O campo ctps é obrigatório.',
            'birthDate' => 'O campo data de nascimento é obrigatório.',
            'cep' => 'O campo cep é obrigatório.',
            'street' => 'O campo endereço é obrigatório.',
            'number' => 'O campo número é obrigatório.',
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

    /**
     * @return array
     */
    public function allWorkingHours()
    {
        return [
            'Diurno',
            'Noturno'
        ];
    }


    /**
     * @return array
     */
    public function allWorkRegime()
    {
        return [
            'Padrão',
            '12x36'
        ];
    }

}
