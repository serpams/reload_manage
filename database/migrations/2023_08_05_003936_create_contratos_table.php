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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras');
            $table->string('numero');
            $table->enum('tipo', ['ADITIVO', 'NORMAL', 'REDUTIVO']);
            $table->date('data')->nullable();
            $table->json('dados')->nullable();
            $table->date('inicio')->nullable();
            $table->date('validade')->nullable();
            $table->timestamps();
        });

        Schema::create('contratos_itens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras');
            $table->unsignedBigInteger('contratos_id');
            $table->foreign('contratos_id')->references('id')->on('contratos');
            $table->string('item');
            $table->string('servico');
            $table->string('unidade')->nullable();
            $table->double('quantidade', 10, 2);
            $table->double('preco', 10, 2);
            $table->double('total', 10, 2);
        });
        Schema::create('contratos_itens_vinculos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras');
            $table->unsignedBigInteger('contratos_id');
            $table->foreign('contratos_id')->references('id')->on('contratos');
            $table->unsignedBigInteger('contrato_item_id');
            $table->foreign('contrato_item_id')->references('id')->on('contratos_itens');
            $table->unsignedBigInteger('orcamento_id');
            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
            $table->double('quantidade', 10, 2);
            $table->double('preco', 10, 2);
            $table->double('total', 10, 2);
        });
        Schema::create('contratos_medicoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras');
            $table->unsignedBigInteger('contratos_id');
            $table->enum('status', ['ABERTA', 'FECHADA', 'REVISAR', 'REVISADA', 'APROVADA', 'PAGA'])->default('ABERTA');
            $table->foreign('contratos_id')->references('id')->on('contratos');
        });
        Schema::create('contratos_medicoes_itens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras');
            $table->unsignedBigInteger('contratos_id');
            $table->foreign('contratos_id')->references('id')->on('contratos');
            $table->unsignedBigInteger('contrato_medicao_id');
            $table->foreign('contrato_medicao_id')->references('id')->on('contratos_medicoes');
            $table->unsignedBigInteger('contrato_item_id');
            $table->foreign('contrato_item_id')->references('id')->on('contratos_itens');
            $table->double('quantidade', 10, 2);
            $table->double('preco', 10, 2);
            $table->double('total', 10, 2);
        });

        Schema::create('contrato_movimentacao_historicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras');
            $table->string('screen');
            $table->string('action');
            $table->string('model');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->json('data');
            $table->timestamps();
        });
        Schema::create('contrato_pagamento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras');
            $table->unsignedBigInteger('contratos_id');
            $table->foreign('contratos_id')->references('id')->on('contratos');
            $table->string('numero');
            $table->date('data');
            $table->unsignedBigInteger('contrato_medicao_id');
            $table->foreign('contrato_medicao_id')->references('id')->on('contratos_medicoes');
            $table->double('quantidade', 10, 2);
            $table->double('preco', 10, 2);
            $table->double('total', 10, 2);
            $table->double('valor', 10, 2);
            $table->string('observacao')->nullable();
            $table->string('nota_fiscal')->nullable();
            $table->timestamps();
        });
        Schema::create('contrato_reajustes',  function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras');
            $table->unsignedBigInteger('contratos_id');
            $table->foreign('contratos_id')->references('id')->on('contratos');
            $table->string('indice');
            $table->double('valor_base', 10, 2);
            $table->double('valor_atual', 10, 2);
            $table->double('valor_reajuste', 10, 2);
            $table->double('valor_reajustado', 10, 2);
            // vincula a uma mediçã contratos_medicoes
            $table->unsignedBigInteger('contrato_medicao_id');
            $table->foreign('contrato_medicao_id')->references('id')->on('contratos_medicoes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
