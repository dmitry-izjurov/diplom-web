<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seances')->insert([
            ['time_begin' => '10:00',
             'film_id' => 1,
             'hall_id' => 1,
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30'],
            ['time_begin' => '14:00',
             'film_id' => 3,
             'hall_id' => 1,
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30'],
            ['time_begin' => '20:20',
             'film_id' => 5,
             'hall_id' => 1,
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30'],
            ['time_begin' => '12:00',
             'film_id' => 2,
             'hall_id' => 2,
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30'],
            ['time_begin' => '18:00',
             'film_id' => 4,
             'hall_id' => 2,
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30']
        ]);
    }
}
