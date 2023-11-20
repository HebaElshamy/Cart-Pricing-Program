<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name'=>'T-shirt',
            'type'=>'Top',
            'price'=>30.99,
            'countries_id'=>1,
            'weight'=>0.2,
            'stock'=>20,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        DB::table('products')->insert([
            'name'=>'Blouse',
            'type'=>'Top',
            'price'=>10.99,
            'countries_id'=>2,
            'weight'=>0.3,
            'stock'=>20,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        DB::table('products')->insert([
            'name'=>'Pants',
            'type'=>'Down',
            'price'=>64.99,
            'countries_id'=>2,
            'weight'=>0.9,
            'stock'=>20,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        DB::table('products')->insert([
            'name'=>'Sweatpants',
            'type'=>'Down',
            'price'=>84.99,
            'countries_id'=>3,
            'weight'=>1.1,
            'stock'=>20,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        DB::table('products')->insert([
            'name'=>'Jacket',
            'type'=>'Top',
            'price'=>199.99,
            'countries_id'=>1,
            'weight'=>2.2,
            'stock'=>20,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        DB::table('products')->insert([
            'name'=>'Shoes',
            'type'=>'Down',
            'price'=>79.99,
            'countries_id'=>3,
            'weight'=>1.3,
            'stock'=>20,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
    }
}
