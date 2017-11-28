<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * @var string
     */
    protected $table = 'documents';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'periodicity',
        'validity',
        'documentTypeId',
        'entityGroup',
        'isActive',
        'createdAt',
        'updatedAt'
    ];

    /**
     * Rules of the validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'periodicity' => 'required',
            'validity' => 'required',
            'documentTypeId' => 'required'
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
            'periodicity.required' => 'O campo periodicidade é obrigatório.',
            'validity.required' => 'O campo validade é obrigatório.',
            'documentTypeId.required' => 'O campo tipo de documento é obrigatório.'
        ];
    }

}
