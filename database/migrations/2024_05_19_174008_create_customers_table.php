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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('celular')->unique()->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->string('nome')->nullable(false);
            $table->string('cpf')->unique()->nullable(false);
            $table->unsignedBigInteger('estate_agent_id');
            $table->foreign('estate_agent_id')->references('id')->on('estate_agents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
