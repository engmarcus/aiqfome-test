<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ClientLoginRequest;
use App\Http\Requests\Auth\ClientRegisterRequest;
use App\Services\Auth\AuthService;
use App\Support\Helpers\Response;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(ClientLoginRequest $requestData)
    {
        $loginData = $requestData->only('email', 'password');

        try{
            $response = $this->authService->signIn($loginData);
            return Response::success( $response ,200);
        }catch(\Exception $error){
            return Response::error($error);
        }
    }

}



