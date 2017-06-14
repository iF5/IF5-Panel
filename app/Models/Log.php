<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'method',
        'userId',
        'createdAt',
        'data'
    ];

}
