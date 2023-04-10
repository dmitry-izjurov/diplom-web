<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('films')->insert([
            ['title' => 'Звёздные войны XXIII: Атака клонированных клонов',
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30',
             'duration' => '130'],
            ['title' => 'Миссия выполнима',
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30',
             'duration' => '120'],
            ['title' => 'Серая пантера',
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30',
             'duration' => '90'],
            ['title' => 'Движение вбок',
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30',
             'duration' => '95'],
            ['title' => 'Кот да Винчи',
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30',
             'duration' => '100'],
        ]);
    }
}
