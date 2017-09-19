<?php

namespace App\Exceptions\Custom;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModelNotFoundCustomException
{
    public static function is(\Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return (object)[
                'error' => true,
                'message' => 'Desculpe nenhum registro foi encontrado.'
            ];
        }
        return (object)['error' => false];
    }
}