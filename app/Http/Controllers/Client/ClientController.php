<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ClientRegisterRequest;
use App\Http\Requests\Client\EditClientRequest;
use App\Http\Requests\Client\RemoveClientRequest;
use App\Http\Requests\Client\ViewClientRequest;
use App\Services\Client\ClientService;
use App\Support\Helpers\Response;

class ClientController extends Controller
{
    private $clientService;
    public function __construct(ClientService $clientService) {
        $this->clientService = $clientService;
    }

    public function create(ClientRegisterRequest $requestData)
    {
        try{
            $client = $this->clientService->createClient($requestData);
            return Response::success($client,201);
        }catch(\Exception $error){
             return Response::error($error);
        }
    }
    public function profile(ViewClientRequest $_)
    {
        try{
            $clientData = $this->clientService->getClient();
            return Response::success($clientData);
        }catch(\Exception $error){
             return Response::error($error);
        }
    }

    public function edit(EditClientRequest $editClientRequest)
    {
        try{
            $clientEdit = $editClientRequest->getClientEditData();
            $clientData = $this->clientService->updatePartial($clientEdit);

            return Response::success($clientData,200);
        }catch(\Exception $error){
             return Response::error($error);
        }
    }
    public function delete(RemoveClientRequest $_)
    {
        try{
            $this->clientService->delete();
            return Response::success(null,204);
        }catch(\Exception $error){
             return Response::error($error);
        }
    }

}



