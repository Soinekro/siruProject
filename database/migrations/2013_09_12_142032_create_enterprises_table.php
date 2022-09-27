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
            $table->foreignId('distrit_id')->unique()->comment('ID de la provincia que pertenece')->constrained('distrits');
            $table->string('ruc', 11)->unique()->comment('RUC de la empresa');
            $table->string('name')->comment('Nombre de la empresa');
            $table->string('address')->comment('Dirección de la empresa');
            $table->string('phone')->comment('Teléfono de la empresa');
            $table->string('social_reason')->comment('Razón social de la empresa');
            $table->string('user_sol')->comment('Usuario SOL');
            $table->string('password_sol')->comment('Contraseña SOL');
            $table->string('certificate')->comment('Certificado de la empresa');
            $table->string('certificate_password')->comment('Contraseña del certificado');
            $table->string('logo')->comment('Logo de la empresa');
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
