<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;


class ClientController extends Controller
{
    public  function __construct()
    {

    }

    public function listAll()
    {
        try{
            return [];
        }catch(\Exception $e){
            return [];
        }
    }

}



