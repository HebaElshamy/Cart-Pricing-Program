<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            'name' => 'US',
            'shipping_rate' => 2,
            'created_at'=>now(),
            'updated_at'=>now(),

        ]);
        DB::table('countries')->insert([
            'name' => 'UK',
            'shipping_rate' => 3,
            'created_at'=>now(),
            'updated_at'=>now(),

        ]);
        DB::table('countries')->insert([
            'name' => 'CN',
            'shipping_rate' => 2,
            'created_at'=>now(),
            'updated_at'=>now(),

        ]);
    }
}
