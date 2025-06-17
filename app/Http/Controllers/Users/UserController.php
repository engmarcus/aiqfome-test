<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;



class UserController extends Controller
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



