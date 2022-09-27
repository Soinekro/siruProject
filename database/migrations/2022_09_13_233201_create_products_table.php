<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del producto');
            $table->string('description')->comment('Descripción del producto');
            $table->string('slug')->unique()->comment('Slug del producto');
            $table->foreignId('category_id')->constrained()->comment('Categoría del producto');
            $table->decimal('price', 8, 2)->comment('Precio del producto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
