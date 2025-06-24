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
        $table->dropColumn('status');
    });
}

public function down()
{
    Schema::table('resep_makans', function (Blueprint $table) {
        $table->string('status')->nullable(); // bisa tambahkan default juga kalau ingin
    });
}

};
