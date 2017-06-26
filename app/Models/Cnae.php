<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cnae extends Model
{
    public $timestamps = false;

    protected $table = 'cnae';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'cnae'
    ];

}
