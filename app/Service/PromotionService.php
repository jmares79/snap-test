<?php

namespace App\Service;

use App\Interfaces\PromotionCreatorInterface;
use App\Exceptions\PromotionCreationException;
use App\Promotion;

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
}
