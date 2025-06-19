<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('client.favorite_products')) {
            Schema::create('client.favorite_products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('product_id');
                $table->timestamps();
                $table->unique(['client_id', 'product_id']);
                /** Relacionamentos */
                $table->foreign('client_id')
                    ->references('id')
                    ->on('client.clients')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::drop('client.favorite_products');
    }
};
