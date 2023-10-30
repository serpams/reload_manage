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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            // relationship id with obras
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras')->onDelete('cascade');
            $table->string('item')->nullable();
            $table->string('servico')->nullable();
            $table->string('medivel')->nullable();
            $table->string('grupo')->nullable();
            $table->string('indice_base')->nullable();
            $table->double('indice_valor', 4, 3)->nullable();
            $table->string('unidade')->nullable();
            $table->double('quantidade', 4, 2)->nullable();
            $table->double('preco', 4, 2)->nullable();
            $table->double('total', 4, 2)->nullable();
            $table->double('total_indexado', 4, 3)->nullable();
            $table->json('data')->nullable();
            $table->string('fistrelationship')->nullable();
            $table->string('parent_id')->nullable();
            $table->integer('level')->nullable();
            $table->integer('ordem')->nullable();
            $table->string('group')->nullable();
            $table->integer('deep')->nullable();
            // create self relationship
            $table->unsignedBigInteger('orcamentos_id')->nullable();
            $table->foreign('orcamentos_id')->references('id')->on('orcamentos')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};