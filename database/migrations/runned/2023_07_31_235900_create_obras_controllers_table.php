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
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('obra');
            $table->string('name')->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('cep')->nullable();
            $table->string('contratante')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('Cliente')->nullable();
            $table->string('Contratada')->nullable();
            // UserResponsavelCliente relationship
            $table->unsignedBigInteger('user_responsavel_cliente_id')->nullable();
            $table->foreign('user_responsavel_cliente_id')->references('id')->on('users')->nullable();
            // UserResponsavelContratada relationship
            $table->unsignedBigInteger('user_responsavel_contratada_id')->nullable();
            $table->foreign('user_responsavel_contratada_id')->references('id')->on('users')->nullable();
            $table->timestamps();
        });

        Schema::create('obras_user', function (Blueprint $table) {
            $table->id();
            //relationship
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras')->nullable();
            //relationship users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            //relationship roles

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};
