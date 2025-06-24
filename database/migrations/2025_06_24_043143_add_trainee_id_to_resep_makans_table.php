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
    Schema::table('resep_makans', function (Blueprint $table) {
        $table->unsignedBigInteger('trainee_id')->after('id');

        // Jika pakai relasi foreign key
        $table->foreign('trainee_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('resep_makans', function (Blueprint $table) {
        $table->dropForeign(['trainee_id']);
        $table->dropColumn('trainee_id');
    });
}

    
};
