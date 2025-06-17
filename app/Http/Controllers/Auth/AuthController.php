<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ClientRegisterRequest;
use App\Models\Client;
use App\Support\Helpers\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function createCount(ClientRegisterRequest $requestData)
    {
        try{
            $client = Client::create([
                'name'     => $requestData->name,
                'email'    => $requestData->email,
                'password' => Hash::make($requestData->password),
            ]);

            return Response::success($client,201);
        }catch(\Exception $error){
             return Response::error($error);
        }
    }

}



