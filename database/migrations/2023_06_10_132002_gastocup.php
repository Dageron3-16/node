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
        Schema::create('gastoscups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')
            ->constrained('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('contenedores_id')
            ->constrained('contenedores')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->string('nombre_gastocup');
            $table->double('valor_gastocup');
            $table->double('total_gastocup');
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
