<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'jobRole',
        'department',
        //'phone',
        'cellPhone',
        'email',
        'password',
        'role',
        'image',
        'createdAt',
        'updatedAt',
        'companyId',
        'providerId'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Rules of the validation
     *
     * @param int $id
     * @return array
     */
    public function validateRules($id = null)
    {
        return [
            'name' => 'required',
            'cpf' => 'required|unique_multiple:users,cpf,id=' . $id,
            'jobRole' => 'required',
            'department' => 'required',
            //'phone' => 'required',
            'cellPhone' => 'required',
            'email' => 'email|unique_multiple:users,email,id=' . $id,
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
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.unique_multiple' => 'O cpf já existe.',
            'jobRole.required' => 'O campo cargo é obrigatório.',
            'department.required' => 'O campo setor é obrigatório.',
            //'phone.required' => 'O campo telefone é obrigatório.',
            'cellPhone.required' => 'O campo celular é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.unique_multiple' => 'O e-mail já existe.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter mínimo de 6 e no máximo 14 caracteres.',
            'password.max' => 'O campo senha deve ter mínimo de 6 e no máximo 14 caracteres.'
        ];
    }
}
