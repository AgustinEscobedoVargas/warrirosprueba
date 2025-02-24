<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('nombre', 50);
            $table->string('apellidos', 100);
            $table->integer('edad');
            $table->string('email', 100)->unique();
            $table->string('telefono', 20)->nullable();
            $table->unsignedBigInteger('id_grupo')->nullable(); 
            $table->foreign('id_grupo')->references('id')->on('grupos')->onDelete('set null');
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
        Schema::dropIfExists('estudiantes');
    }
}
