<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('program_latihan', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->date('tanggal');
        $table->string('jenis_latihan');
        $table->text('details');
        $table->string('status')->default('belum');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_latihan');
    }
};
