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
        // create a table custom
        Schema::create('customs', function (Blueprint $table) {
            $table->id();
            //relationship to project
            $table->unsignedBigInteger('obras_id');
            $table->foreign('obras_id')->references('id')->on('obras')->nullable();
            $table->string('resume')->nullable();
            $table->string('action')->nullable();
            $table->string('role')->nullable();
            $table->string('values')->nullable();
            $table->json('data')->nullable();
            $table->json('custom')->nullable();
            $table->json('special')->nullable();
            $table->json('can')->nullable();
            $table->json('canot')->nullable();
            $table->timestamps();
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
