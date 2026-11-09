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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('rol_Id')->after('id')
              ->constrained('roles')->resctrictOnDelete();
            $table->char('dni',8)->unique()->after('name');
            $table->string('telefono',15)->nullable()->after('dni');
            $table->string('colegiatura',20)->nullable()->after('telefono');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('rol_id');
            $table->dropUnique(['dni']);
            $table->dropColumn(['dni','telefono','colegiatura']);
        });
    }
};
