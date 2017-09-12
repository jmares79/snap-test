<?php

use Illuminate\Database\Seeder;

class CheckoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checkouts')->insert([
            'product_code' => "SR1",
        ]);
        DB::table('checkouts')->insert([
            'product_code' => "SR1",
        ]);
        DB::table('checkouts')->insert([
            'product_code' => "SR1",
        ]);
        DB::table('checkouts')->insert([
            'product_code' => "FR1",
        ]);

    }
}
