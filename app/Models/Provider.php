<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'cnpj',
        'stateInscription',
        'municipalInscription',
        'mainCnae',
        'activityBranch',
        'cep',
        'number',
        'addressComplement',
        'phone',
        'fax',
        'email'
    ];

    /**
     * Rules of the validation
     *
     * @param null $id
     * @return array
     */
    public function validateRules($id = null)
    {
        return [
            'name' => 'required',
            'cnpj' => 'required|unique_multiple:companies,cnpj,name,id=' . $id,
            'stateInscription' => 'required',
            'municipalInscription' => 'required',
            'mainCnae' => 'required',
            'activityBranch' => 'required',
            'cep' => 'required',
            'number' => 'required',
            'addressComplement' => 'required',
            'phone' => 'required',
            'email' => 'required'
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
            'cnpj.required' => 'O campo cnpj é obrigatório.',
            'cnpj.unique_multiple' => 'O nome e o cnpj do prestador de serviços já existe.',
            'stateInscription.required' => 'O campo inscrição estadual é obrigatório.',
            'municipalInscription.required' => 'O campo inscrição minicipal é obrigatório.',
            'mainCnae.required' => 'O campo cnae principal é obrigatório.',
            'activityBranch.required' => 'O campo ramo de atividade é obrigatório.',
            'cep.required' => 'O campo cep é obrigatório.',
            'number.required' => 'O campo numero é obrigatório.',
            'addressComplement.required' => 'O campo complemento é obrigatório.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.'
        ];
    }

}
