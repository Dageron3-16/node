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
        Schema::create('gastosusds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')
            ->constrained('users')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('contenedores_id')
            ->constrained('contenedores')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->string('nombre_gastousd');
            $table->double('valor_gastousd');
            $table->double('total_gastousd');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
