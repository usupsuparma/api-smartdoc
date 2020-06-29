<?php namespace App\Helpers;

use Illuminate\Support\Str;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use DateTime;
use App\Library\Bases\BaseController;

class BearerToken extends BaseController
{
	protected $server;
    protected $tokens;

    public function __construct(ResourceServer $server, TokenRepository $tokens) {
        $this->server = $server;
        $this->tokens = $tokens;
	}
	
	public static function get_token($request)
	{
		
		$psr = (new DiactorosFactory)->createRequest($request, $localCall = false);

        try {
            $psr = $this->server->validateAuthenticatedRequest($psr);

            $token = $this->tokens->find(
                $psr->getAttribute('oauth_access_token_id')
            );
            $currentDate = new DateTime();
            $tokenExpireDate = new DateTime($token->expires_at);

            $isAuthenticated = $tokenExpireDate > $currentDate ? true : false;

            if($localCall) {
                return $isAuthenticated;
            }
            else {
                return json_encode(array('authenticated' => $isAuthenticated));
            }
        } catch (OAuthServerException $e) {
            if($localCall) {
                return false;
            }
            else {
                return json_encode(array('error' => 'Something went wrong with authenticating. Please logout and login again.'));
            }
        }
	}
}