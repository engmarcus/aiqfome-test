<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ClientLoginRequest;
use App\Http\Requests\Auth\ClientResetPassword;
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

    public function resetPassword(ClientResetPassword $requestData)
    {
        try{
            $data = $requestData->getClientData();
            $response = $this->authService->resetPassword($data);
            return Response::success( $response ,200);
        }catch(\Exception $error){
            return Response::error($error);
        }
    }
    public function me()
    {
        try {
            $userData = $this->authService->getAuthenticatedUser();
            return Response::success($userData);
        } catch (\Exception $error) {
            return Response::error($error);
        }
    }

    public function logout()
    {
        try {
            $this->authService->logout();
            return Response::success('Logged out successfully', 200);
        } catch (\Exception $error) {
            return Response::error($error);
        }
    }


}



