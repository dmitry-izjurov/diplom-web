<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'admin',
             'email' => 'admin@mail.ru',
             'password' => '$2y$10$IK3YfFT1h.UAj89ifyxWqO3qn9L4x.IHYvZdktPuYVKXAP/Uh9O3C',
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30'],
        ]);
    }
}
