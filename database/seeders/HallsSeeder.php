<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HallsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('halls')->insert([
            ['title' => 'Зал 1',
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30',
             'is_sell_ticket' => 'true',
             'types_of_chairs' => 'd,d,d,s,s,d,d,d|d,d,s,s,s,s,d,d|d,s,s,s,s,s,s,d|s,s,s,v,v,s,s,s|s,s,v,v,v,v,s,d|s,s,v,v,v,v,s,d|s,s,v,v,v,v,s,d|s,s,s,s,s,s,s,d|s,s,s,s,s,s,s,s|s,s,s,s,s,s,s,s',
             'price_of_chair' => 's:150|v:350'],
            ['title' => 'Зал 2',
             'created_at' => '2023-03-31 17:44:30',
             'updated_at' => '2023-03-31 17:44:30',
             'is_sell_ticket' => 'false',
             'types_of_chairs' => 'd,d,d,s,s,d,d,d|d,d,s,s,s,s,d,d|d,s,s,s,s,s,s,d|s,s,s,v,v,s,s,s|s,s,v,v,v,v,s,d|s,s,v,v,v,v,s,d|s,s,v,v,v,v,s,d|s,s,s,s,s,s,s,d|s,s,s,s,s,s,s,s|s,s,s,s,s,s,s,s',
             'price_of_chair' => 's:150|v:350'],
        ]);
    }
}
