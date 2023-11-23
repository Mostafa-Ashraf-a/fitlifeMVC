<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $local = 'en';
        if(($request->hasHeader('X-localization')) && $request->header('X-localization') == 'ar' || $request->header('X-localization') == 'en'){
            $local = $request->header('X-localization');
        }
        app()->setLocale($local);
        return $next($request);
    }
}
