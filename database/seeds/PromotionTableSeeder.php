<?php

use Illuminate\Database\Seeder;

class PromotionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('promotions')->insert([
            'product_code' => "SR1",
            'minimum_qty' => 3,
            'promotion_price' => 4.50
        ]);
    }
}
