<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('fk_estudiante');
            $table->foreign('fk_estudiante')->references('id')->on('users');

            $table->string('ruta_informe')->nullable(); //archivo_informe
            $table->string('descripcion'); //descripcion_informe
            $table->timestamp('fecha_envio');
            $table->enum('estado', ['aprobado', 'pendiente', 'rechazado'])->default('pendiente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes');
    }
};
