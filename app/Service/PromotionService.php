<?php

namespace App\Service;

use App\Interfaces\PromotionCreatorInterface;
use App\Exceptions\PromotionCreationException;
use App\Promotion;

/**
 * @resource Promotion
 *
 * Promotion service to handle all needed operations for promotions
 */
class PromotionService implements PromotionCreatorInterface
{
   /**
    * Creates a new promotion for the site
    *
    * @param mixed $payload Array with promotion data
    *
    * @return void
    * @throws PromotionCreationException On creation error
    */
    public function create($payload)
    {
        $promotion = new Promotion;

        $promotion->product_code = $payload->product_code;
        $promotion->minimum_qty = $payload->minimum_qty;
        $promotion->promotion_price = $payload->promotion_price;

        if (!$promotion->save()) throw new PromotionCreationException();
    }

    public function getPromotionByProduct($product)
    {

    }

    public function hasPromotion($product, $quantity)
    {
        $price = \App\Promotion::where([
            ['product_code', '=', $product],
            ['minimum_qty', '<=', $quantity]
        ])->pluck('promotion_price');

        if (count($price->toArray()) == 0) {
            return false;
        } else {
            return $price->toArray()[0];
        }
    }
}
