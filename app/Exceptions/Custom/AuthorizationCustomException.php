<?php

namespace App\Exceptions\Custom;

use Illuminate\Auth\Access\AuthorizationException;

class AuthorizationCustomException
{
    public static function is(\Exception $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return (object)[
                'error' => true,
                'message' => 'Desculpe voc&ecirc; n&atilde;o tem permiss&atilde;o para acessar este conte&uacute;do.'
            ];
        }
        return (object)['error' => false];
    }
}