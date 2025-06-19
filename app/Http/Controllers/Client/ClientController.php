<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ClientRegisterRequest;
use App\Services\Client\ClientService;
use App\Support\Helpers\Response;

class ClientController extends Controller
{
    private $authService;
    public function __construct(ClientService $authService) {
        $this->authService = $authService;
    }

    public function create(ClientRegisterRequest $requestData)
    {
        try{
            $client = $this->authService->createClient($requestData);
            return Response::success($client,201);
        }catch(\Exception $error){
             return Response::error($error);
        }
    }
}



