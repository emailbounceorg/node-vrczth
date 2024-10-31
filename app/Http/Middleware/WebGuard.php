<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class WebGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            // User is not logged in, redirect to login page or return a response
            return redirect('/')->with('error', "Can't access without login");
        }
        if (auth()->check()) {
            $User = User::select('timezones')->where('id', auth()->user()->id)->latest()->first();
            if (!is_null($User) && !empty($User->timezones)) {
                Config::set('app.timezone', $User->timezones);
                date_default_timezone_set($User->timezones); // Optional: set default PHP timezone
            }
        }
        return $next($request);
    }
}
