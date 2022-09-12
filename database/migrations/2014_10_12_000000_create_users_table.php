<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('dni', 8)->unique()->comment('DNI del usuario');
            $table->string('name')->comment('Nombre del usuario');
            $table->string('father_lastname')->comment('Apellido paterno del usuario');
            $table->string('mother_lastname')->comment('Apellido materno del usuario');
            $table->date('birthdate')->comment('Fecha de nacimiento del usuario');
            $table->string('email')->unique()->comment('Correo electrónico del usuario');
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', [User::ACTIVO, User::INACTIVO])->default(User::ACTIVO)->comment('Estado del usuario');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
