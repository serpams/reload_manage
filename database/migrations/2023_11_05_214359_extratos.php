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
        Schema::create('extratos', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->dateTime('data')->nullable();
            $table->enum('banco', ['bb', 'itau']);
            $table->string('file_url')->nullable();
            $table->longText('text');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
        Schema::create('extrato_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('extrato_id');
            $table->foreign('extrato_id')->references('id')->on('extratos');
            $table->string('tipo')->nullable();
            $table->string('data')->nullable();
            $table->string('descricao')->nullable();
            $table->string('valor')->nullable();
            $table->string('nome')->nullable();
            $table->string('documento')->nullable();
            $table->string('origem_banco')->nullable();
            $table->timestamps();
        });
        Schema::create('extrato_transaction_concilied', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('extrato_transaction_id');
            $table->foreign('extrato_transaction_id')->references('id')->on('extrato_transactions');
            $table->unsignedBigInteger('comprovante_id')->nullable();
            $table->string('comprovante_url')->nullable();
            $table->foreign('comprovante_id')->references('id')->on('comprovantes');
            $table->string('comprovante_text')->nullable();
            $table->string('data')->nullable();
            $table->string('valor')->nullable();
            $table->string('documento')->nullable();
            $table->string('origem_banco')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extrato_transaction_concilied');
        Schema::dropIfExists('extrato_transactions');
        Schema::dropIfExists('extratos');
    }
};
