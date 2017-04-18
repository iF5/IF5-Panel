<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'fantasyName',
        'activityBranch',
        'cnpj',
        'stateInscription',
        'municipalInscription',
        'mainCnae',
        'phone',
        'fax',
        'cep',
        'street',
        'number',
        'district',
        'city',
        'state',
        'responsibleName',
        'cellPhone',
        'email',
        'createdAt',
        'updatedAt'
    ];

    /**
     * Rules of the validation
     *
     * @param null $id
     * @param null $userId
     * @return array
     */
    public function validateRules($id = null, $userId = null)
    {
        return [
            'name' => 'required',
            'fantasyName' => 'required',
            'activityBranch' => 'required',
            'cnpj' => 'required|unique_multiple:companies,cnpj,name,id=' . $id,
            'stateInscription' => 'required',
            'municipalInscription' => 'required',
            'mainCnae' => 'required',
            'phone' => 'required',
            'fax' => 'required',
            'cep' => 'required',
            'street' => 'required',
            'number' => 'required',
            'district' => 'required',
            'city' => 'required',
            'state' => 'required',
            'responsibleName' => 'required',

            'cpf' => 'required|unique_multiple:users,cpf,id=' . $userId,
            'jobRole' => 'required',
            'department' => 'required',
            'email' => 'email|unique_multiple:users,email,id=' . $userId,
            'password' => 'required|min:6|max:14'

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
            'fantasyName' => 'O campo nome fantasia é obrigatório.',
            'activityBranch.required' => 'O campo ramo de atividade é obrigatório.',
            'cnpj.required' => 'O campo cnpj é obrigatório.',
            'cnpj.unique_multiple' => 'O nome e o cnpj da empresa já existe.',
            'stateInscription.required' => 'O campo inscrição estadual é obrigatório.',
            'municipalInscription.required' => 'O campo inscrição minicipal é obrigatório.',
            'mainCnae.required' => 'O campo cnae principal é obrigatório.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'fax.required' => 'O campo fax é obrigatório.',
            'cep.required' => 'O campo cep é obrigatório.',
            'street.required' => 'O campo logradouro é obrigatório.',
            'number.required' => 'O campo número é obrigatório.',
            'district.required' => 'O campo bairro é obrigatório.',
            'city.required' => 'O campo cidade é obrigatório.',
            'state.required' => 'O campo UF é obrigatório.',
            'responsibleName.required' => 'O campo nome responsável é obrigatório.',

            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.unique_multiple' => 'O cpf já existe.',
            'jobRole.required' => 'O campo cargo é obrigatório.',
            'department.required' => 'O campo setor é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.unique_multiple' => 'O e-mail já existe.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter mínimo de 6 e no máximo 14 caracteres.',
            'password.max' => 'O campo senha deve ter mínimo de 6 e no máximo 14 caracteres.'
        ];
    }

}
