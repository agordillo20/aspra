<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescripcion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripcion', function (Blueprint $table) {
            $table->id();
            $table->string('campo1');
            $table->string('campo2');
            $table->string('campo3');
            $table->string('campo4');
            $table->string('campo5');
            $table->string('campo6');
            $table->string('campo7');
            $table->string('campo8');
            $table->string('campo9');
            $table->string('campo10');
            $table->string('campo11');
            $table->string('campo12');
            $table->string('campo13');
            $table->string('campo14');
            $table->string('campo15');
            $table->string('campo16');
            $table->string('campo17');
            $table->string('campo_otros');
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
        Schema::dropIfExists('descripcion');
    }
}
