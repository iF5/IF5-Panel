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
        'phoneNumber',
        'cellPhoneNumber',
        'email',
        'password',
        'role',
        'image',
        'createdAt',
        'updateAt',
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
            'name' => 'required|min:3',
            'cpf' => 'required',
            'jobRole' => 'required',
            'department' => 'required',
            'phoneNumber' => 'required',
            'cellPhoneNumber' => 'required',
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
            'jobRole.required' => 'O campo cargo é obrigatório.',
            'department.required' => 'O campo setor é obrigatório.',
            'phoneNumber.required' => 'O campo telefone é obrigatório.',
            'cellPhoneNumber.required' => 'O campo celular é obrigatório.',
            'name.min' => 'O campo nome deve ter no mínimo 4 caracteres.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.unique_multiple' => 'O e-mail já existe.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter mínimo de 6 e no máximo 14 caracteres.',
            'password.max' => 'O campo senha deve ter mínimo de 6 e no máximo 14 caracteres.'
        ];
    }
}
