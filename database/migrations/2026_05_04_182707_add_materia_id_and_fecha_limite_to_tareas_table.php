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
        Schema::table('tareas', function (Blueprint $table) {
            $table->foreignId('materia_id')->nullable()->after('creado_por')->constrained('materias')->nullOnDelete();
            $table->date('fecha_limite')->nullable()->after('materia_id');
        });
    }

    public function down(): void
    {
        Schema::table('tareas', function (Blueprint $table) {
            $table->dropForeign(['materia_id']);
            $table->dropColumn(['materia_id', 'fecha_limite']);
        });
    }
};
