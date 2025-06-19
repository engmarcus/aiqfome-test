<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApplicationOnTest extends TestCase
{
    /**
     * Testa se a aplicação está online através da rota /up.
     */
    public function test_application_returns_success_response(): void
    {

        $response = $this->get('/up');
        $response->assertStatus(200);

    }
}



