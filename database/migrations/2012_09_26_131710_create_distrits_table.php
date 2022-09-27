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
        Schema::create('distrits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del distrito');
            $table->char('code_ubg', 2)->comment('Código de ubigeo del distrito');
            $table->foreignId('province_id')->constrained()->comment('Id de la provincia a la que pertenece el distrito');
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
        Schema::dropIfExists('distrits');
    }
};
