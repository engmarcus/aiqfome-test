<?php

return [
    'baseUrl' => env('FAKESTORE_API_BASE_URL', 'https://fakestoreapi.com'),
    'products' => [
        'get'    => '/products/{id}',
        'list'   => '/products',
    ]
];
