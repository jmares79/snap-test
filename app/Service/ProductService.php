<?php

namespace App\Service;

use App\Exceptions\ProductCreationException;
use App\Service\PromotionService;
use App\Product;

class ProductService
{
   protected $promotion;

    public function __construct(PromotionService $promotion)
    {
        $this->promotion = $promotion;
    }

   /**
    * Creates a new product for the site
    *
    * @param mixed $payload Array with product data
    *
    * @return void
    * @throws ProductCreationException On creation error
    */
    public function create($payload)
    {
        $product = new Product;

        $product->code = $payload->code;
        $product->name = $payload->name;
        $product->price = $payload->price;

        if (!$product->save()) throw new ProductCreationException();
    }

    public function getPrice($product, $quantity)
    {
        $price = $this->promotion->hasPromotion($product, $quantity);

        if ($price !== false) {
            return $price;
        } else {
            return \App\Product::where('code', $product)->pluck('price')->toArray()[0];
        }
    }
}
