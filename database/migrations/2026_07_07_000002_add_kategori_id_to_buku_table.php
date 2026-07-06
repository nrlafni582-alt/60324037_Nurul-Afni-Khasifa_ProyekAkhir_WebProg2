<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_id')->nullable()->after('kategori');
        });

        // Migrate existing kategori strings into kategoris
        $kategoris = DB::table('buku')
            ->select('kategori')
            ->distinct()
            ->whereNotNull('kategori')
            ->pluck('kategori')
            ->filter()
            ->toArray();

        foreach ($kategoris as $nama) {
            $id = DB::table('kategoris')->insertGetId([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('buku')->where('kategori', $nama)->update(['kategori_id' => $id]);
        }

        Schema::table('buku', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });

        Schema::dropIfExists('kategoris');
    }
};
