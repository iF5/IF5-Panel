<?php

namespace App\Exceptions\Custom;

use Illuminate\Auth\Access\AuthorizationException;

class AuthorizationCustomException
{
    public static function is(\Exception $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return [
                'error' => true,
                'route' => 'access.denied' 
            ];
        }
        return ['error' => false];
    }
}