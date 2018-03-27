<?php
/**
 * Created by PhpStorm.
 * User: tma
 * Date: 12/14/2016
 * Time: 9:23 AM
 */

namespace App\Http\Middleware;
use Closure;

class AdminAuthenticate
{
    public function handle($request, Closure $next)
    {
        if(auth()->check() && auth()->user()->is_admin()) {
            return $next($request);
        }
         $redirect_to = url('/') . '/login';
        return redirect($redirect_to);
    }
}