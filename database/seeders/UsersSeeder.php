<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama_user' => 'Joko',
                'username' => 'admin1',
                'password' => Hash::make('1234'), // Encrypting the password
                'email' => 'admin@unair.com',
                'no_hp' => '1234567890',
                'id_jenis_user' => 1,
                'status_user' => 'active',
                'delete_mark' => 'N',
                'create_by' => 'system',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_user' => 'Nadhiv',
                'username' => 'mahasiswa1',
                'password' => Hash::make('1234'),
                'email' => 'mahasiswa@unair.com',
                'no_hp' => '0987654321',
                'id_jenis_user' => 2,
                'status_user' => 'active',
                'delete_mark' => 'N',
                'create_by' => 'system',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_user' => 'Tesa',
                'username' => 'dosen1',
                'password' => Hash::make('1234'),
                'email' => 'dosen@unair.com',
                'no_hp' => '0987654321',
                'id_jenis_user' => 3,
                'status_user' => 'active',
                'delete_mark' => 'N',
                'create_by' => 'system',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
