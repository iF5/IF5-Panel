<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'referenceDate',
        'fileName',
        'fileOriginalName',
        'companyId',
        'createdAt',
        'sentAt'
    ];

    /**
     * Rules of the validation
     *
     * @return array
     */
    public function validateRules()
    {
        return [
            'name' => 'required',
            'referenceDate' => 'required'
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
            'referenceDate' => 'O campo data de referência fantasia é obrigatório.'
        ];
    }

}
