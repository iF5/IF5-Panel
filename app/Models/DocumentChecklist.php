<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentChecklist extends Model
{
    /**
     * @var string
     */
    protected $table = 'document_checklists';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'entityGroup',
        'entityId',
        'documentId',
        'referenceDate',
        'validity',
        'status',
        'observation',
        'sentAt',
        'resentAt',
        'approvedAt',
        'reusedAt',
        'fileName',
        'originalFileName'
    ];


}