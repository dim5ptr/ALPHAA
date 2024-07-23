<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiToken
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('access_token')) {
            return $next($request);
        }

        return redirect()->route('login')->withErrors(['error' => 'Unauthorized']);
    }
}
