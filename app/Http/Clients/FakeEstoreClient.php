<?php

namespace App\Http\Clients;

use App\Support\HttpClient;


class FakeEstoreClient extends HttpClient
{

    public function __construct() {
        $baseUrl = config('fakeapi.baseUrl');
        $this->config( $baseUrl);
    }

    public function fetchProduct(int $productId)
    {
        $endPoint = config('fakeapi.products.get');
        $endPoint = str_replace('{id}', $productId, $endPoint);
        try{

            $dataProduct = $this->get($endPoint);

            dd(  $dataProduct);
        }catch(\Exception $error){
            throw $error;
        }
    }
}
