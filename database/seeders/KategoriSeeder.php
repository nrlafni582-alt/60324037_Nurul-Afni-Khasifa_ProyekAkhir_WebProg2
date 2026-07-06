<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::insert([
            ['nama' => 'Programming', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Database', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Web Design', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Networking', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Data Science', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
