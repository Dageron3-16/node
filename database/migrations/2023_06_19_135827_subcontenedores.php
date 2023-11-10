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
         Schema::create('subcontenedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')
            ->constrained('users')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->string('name');
            $table->string('provedor');
            $table->double('costo_contenedor', 8, 2);
            $table->double('valorusd_mercado');
            $table->double('costo_contenedor_limpio');
            $table->double('flete', 8, 4);
            $table->double('total_gastocup');
            $table->double('total_gastousd');
            $table->date('fecha');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
