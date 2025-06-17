<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;



class ProductController extends Controller
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



