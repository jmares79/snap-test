<?php

namespace App\Interfaces;

/**
 *  Interface for a concrete checkout service
 */
interface CheckoutInterface
{
    public function scan($productCode);
}
