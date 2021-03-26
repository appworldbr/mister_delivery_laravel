<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureIsAdmin
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
        if($request->getMethod() == "POST"){
            if(auth()->user()){
                $user = auth()->user();
            } else {
                $email = $request->input('email');
                $user = User::where('email', $email)->first();
            }
            if($user && $user->is_admin){
                return $next($request);
            }
            return abort(401);
        }
        return $next($request);
    }
}
