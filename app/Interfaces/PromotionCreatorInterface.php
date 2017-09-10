<?php

namespace App\Interfaces;

/**
 *  Interface for a concrete promotion service
 */
interface PromotionCreatorInterface
{
    public function create($payload);
}
