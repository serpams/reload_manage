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
        Schema::create('sites', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('sellers', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamps();
        });
        Schema::create('clients', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->dateTime('data');
            $table->enum('type', ['compra', 'venda']);
            $table->double('valor', 8, 2);
            $table->double('cotacao', 8, 2);
            // fk client
            $table->unsignedBigInteger('clients_id');
            $table->foreign('clients_id')->references('id')->on('clients')->nullable();
            // fk seller
            $table->unsignedBigInteger('sellers_id');
            $table->foreign('sellers_id')->references('id')->on('sellers')->nullable();
            // fk user
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->nullable();
            // fk sites
            $table->unsignedBigInteger('sites_id');
            $table->foreign('sites_id')->references('id')->on('sites')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
        Schema::dropIfExists('sellers');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('transactions');
    }
};
