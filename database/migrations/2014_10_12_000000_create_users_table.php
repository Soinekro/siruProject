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
            $table->foreignId('enterprise_id')->comment('llave foranea desde enterprises')->constrained('enterprises');
            $table->enum('rol', [User::ADMIN, User::ENTERPRISE,User::EMPLOYE])->comment('Rol del usuario');
            $table->char('dni', 8)->unique()->comment('DNI del usuario');
            $table->string('name')->comment('Nombre del usuario');
            $table->string('lastname')->comment('Apellido paterno del usuario');
            $table->string('email')->unique()->comment('Correo electrónico del usuario');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('contraseña de usuario');
            $table->rememberToken();
            $table->enum('status', [User::ACTIVO, User::INACTIVO])->default(User::ACTIVO)->comment('Estado del usuario');
            $table->boolean('password_status')->default(false)->comment('estado de generacion de contraseña');
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
