<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('resep_makans', function (Blueprint $table) {
            // Tambahkan kolom trainee_id yang boleh null dulu
            

            // Foreign key bisa diaktifkan nanti setelah data existing valid
            // $table->foreign('trainee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('resep_makans', function (Blueprint $table) {
            // Hapus foreign key jika sempat ditambahkan
            // $table->dropForeign(['trainee_id']);

            $table->dropColumn('trainee_id');
        });
    }
};
