<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::factory()->create([
            'name' => 'Client One',
            'email' => 'client1@example.com',
        ]);

        Client::factory()->create([
            'name' => 'Client Two',
            'email' => 'client2@example.com',
        ]);
    }
}
