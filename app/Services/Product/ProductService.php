<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepository;

class ProductService
{
    private $productRepository;
    public function __construct(
        ProductRepository $productRepository
    ){}


}



