<?php namespace App\Http\Middleware;

use Closure;
use App\Helpers\BearerToken;

class CheckApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('token') && empty($request->get('token'))) {
            return response()->json(['error' => 'Unauthorized', 'code' => 401], 401);
        }
        
        $token = new BearerToken($request->get('token'));
        
        if ($token->valid) {
            if ($token->existsValid()) {
                return $next($request); 
            }
            
            return response()->json(['error' => 'Unauthorized', 'code' => 401], 401);
        }
    }
}