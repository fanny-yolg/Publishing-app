<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;
    
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Authenticate user before access api.
     *
     * @param $request
     * @param Closure $next
     * @return $next
     */
    public function handle($request, Closure $next)
    {
        if($request->bearerToken()) {
            [$id, $bearer] = explode('|', $request->bearerToken(), 2);
            if ($token = DB::table('personal_access_tokens')->where('token', hash('sha256',$bearer))->first()) {
                if ($user = User::find($token->tokenable_id))
                {
                    session()->put('user_data', json_encode($user));
                    session()->put('user_token', $request->bearerToken());
                    return $next($request);
                }
            }
    
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
            ], 401);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
            ], 401);
        }
    }
}
