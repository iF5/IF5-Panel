<?php

namespace App\Http\Middleware;

class HttpsProtocol
{
    public function handle($request, \Closure $next)
    {
        if (IF5_ENV === 'production') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
