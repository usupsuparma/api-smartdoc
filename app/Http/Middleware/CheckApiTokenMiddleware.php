<?php namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class CheckApiToken
{
	protected $server;
	protected $tokens;

    public function __construct(ResourceServer $server, TokenRepository $tokens)
    {
        $this->server = $server;
        $this->tokens = $tokens;
    }
    


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$psr = (new DiactorosFactory)->createRequest($request);
		$psr = $this->server->validateAuthenticatedRequest($psr);
		$token = $this->tokens->find($psr->getAttribute('oauth_access_token_id'));
            
		$date_now = Carbon::now();
		$tokendate = $token->expires_at;
		
        if ($tokendate >= $date_now) {
			return $next($request);
        }else{
            return response()->json(401);
        }
        
        return $next($request); 
        
    }
}