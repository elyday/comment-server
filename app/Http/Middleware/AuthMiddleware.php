<?php

namespace App\Http\Middleware;


use App\Helper\FormatHelper;
use Auth0\SDK\JWTVerifier;
use Closure;
use Exception;
use Illuminate\Http\Request;

class AuthMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $returnArray = array();

        if (!$request->hasHeader('Authorization')) {
            $returnArray["error-code"] = "authorization-header-not-found";
        }

        $token = $request->bearerToken();

        if ($request->header('Authorization') == null || $token == null) {
            $returnArray["error-code"] = "no-token-provided";
        } else if (!$this->retrieveAndValidateToken($token)) {
            $returnArray["error-code"] = "token-is-not-valid";
        }

        if (!empty($returnArray)) {
            return FormatHelper::formatData($returnArray, false, 401);
        }

        return $next($request);

    }

    /**
     * Check the given Token.
     *
     * @param string $token
     * @return bool
     */
    private function retrieveAndValidateToken($token)
    {
        try {
            $verifier = new JWTVerifier([
                'supported_algs' => ["RS256"],
                'valid_audiences' => ['https://comment.eynet.xyz/'],
                'authorized_iss' => ['https://comment-server.eu.auth0.com/'],
            ]);

            $verifier->verifyAndDecode($token);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
