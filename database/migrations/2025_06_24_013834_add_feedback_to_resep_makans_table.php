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
        $table->string('feedback')->nullable()->after('kalori');
    });
}

public function down()
{
    Schema::table('resep_makans', function (Blueprint $table) {
        $table->dropColumn('feedback');
    });
}

};
