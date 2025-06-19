<?php

namespace App\Http\Middleware;

use App\Support\Helpers\Response as HelpersResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
            $this->isValidToken();
        } catch (Exception $e) {

            return HelpersResponse::unauthenticated();
        }

        return $next($request);
    }

    private function isValidToken()
    {
        $user = auth()->user();
        $payload = JWTAuth::getPayload();
        $isValid = $user->remember_token == $payload->get('remember_token');
        if(!$isValid) throw new Exception('Invalid Token');
    }
}
