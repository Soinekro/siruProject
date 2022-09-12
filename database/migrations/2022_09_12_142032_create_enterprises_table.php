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
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11)->unique()->comment('RUC de la empresa');
            $table->string('name')->comment('Nombre de la empresa');
            $table->string('password')->comment('Contraseña de la empresa');
            $table->foreignId('user_id')->comment('ID del usurio')->constrained('users');
            $table->string('user_sol')->comment('Usuario SOL');
            $table->string('password_sol')->comment('Contraseña SOL');
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
        Schema::dropIfExists('enterprises');
    }
};
