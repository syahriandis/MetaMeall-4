<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('program_latihan', function (Blueprint $table) {
            $table->unsignedBigInteger('trainee_id')->nullable()->after('id');
            $table->foreign('trainee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('program_latihan', function (Blueprint $table) {
            $table->dropForeign(['trainee_id']);
            $table->dropColumn('trainee_id');
        });
    }
};
