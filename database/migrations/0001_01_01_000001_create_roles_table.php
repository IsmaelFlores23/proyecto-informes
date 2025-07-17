<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_role');
            $table->timestamps();
        });

        // Insertar roles predefinidos
        DB::table('roles')->insert([
            ['nombre_role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_role' => 'docente', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_role' => 'alumno', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
