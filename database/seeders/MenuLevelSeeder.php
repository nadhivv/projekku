<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_levels')->insert([
            [
                'level' => 'menu',
                'create_by' => 'system',
                // 'delete_mark' => 'N',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level' => 'submenu',
                'create_by' => 'system',
                // 'delete_mark' => 'N',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
