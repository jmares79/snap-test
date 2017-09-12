<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'code' => "SR1",
            'name' => "Strawberries",
            'price' => 5.00
        ]);

         DB::table('products')->insert([
            'code' => "FR1",
            'name' => "Fruit tea",
            'price' => 3.11
        ]);

          DB::table('products')->insert([
            'code' => "CF1",
            'name' => "Coffee",
            'price' => 11.23
        ]);
    }
}
