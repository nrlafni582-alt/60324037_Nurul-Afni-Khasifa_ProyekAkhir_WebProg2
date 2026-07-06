<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop legacy `kategori` table if exists (we will backup before running migration)
        if (Schema::hasTable('kategori')) {
            Schema::dropIfExists('kategori');
        }
    }

    public function down()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 50)->unique();
            $table->text('deskripsi')->nullable();
            $table->string('icon')->nullable();
            $table->string('warna')->nullable();
            $table->timestamps();
        });
    }
};
