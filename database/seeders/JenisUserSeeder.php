<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_users')->insert([
            [
                'jenis_user' => 'admin',
                'create_by' => 'system',
                'delete_mark' => 'N',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_user' => 'mahasiswa',
                'create_by' => 'system',
                'delete_mark' => 'N',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_user' => 'dosen',
                'create_by' => 'system',
                'delete_mark' => 'N',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}
