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
        // add enum to contratos status ['PREENCHIMENTO','AGUARDANDO','REVISAR','REVISADO','APROVADO','CONCLUIDO']
        Schema::table('contratos', function (Blueprint $table) {
            $table->enum('situacao', ['PREENCHIMENTO', 'AGUARDANDO', 'REVISAR', 'REVISADO', 'APROVADO', 'CONCLUIDO'])->default('PREENCHIMENTO');
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
