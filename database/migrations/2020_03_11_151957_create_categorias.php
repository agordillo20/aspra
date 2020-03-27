<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string("descripcion1");
            $table->string("descripcion2");
            $table->string("descripcion3");
            $table->string("descripcion4");
            $table->string("descripcion5");
            $table->string("descripcion6");
            $table->string("descripcion7");
            $table->string("descripcion8");
            $table->string("descripcion9");
            $table->string("descripcion10");
            $table->string("descripcion11");
            $table->string("descripcion12");
            $table->string("descripcion13");
            $table->string("descripcion14");
            $table->string("descripcion15");
            $table->string("descripcion16");
            $table->string("descripcion17");
            $table->string("otras_caracteristicas");
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
        Schema::dropIfExists('categorias');
    }
}
