<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de proveedores con sus datos de contacto.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('ruc', 11)->unique();
            $table->string('phone', 9)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('address', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla de proveedores al revertir esta migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
