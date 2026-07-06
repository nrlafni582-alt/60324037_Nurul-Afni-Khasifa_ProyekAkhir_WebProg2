<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('transaksis') && ! Schema::hasTable('transaksi')) {
            Schema::rename('transaksis', 'transaksi');
        }
    }

    public function down()
    {
        if (Schema::hasTable('transaksi') && ! Schema::hasTable('transaksis')) {
            Schema::rename('transaksi', 'transaksis');
        }
    }
};
