<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập!');
        }

        return $next($request);
    }
}
