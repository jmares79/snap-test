<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    /**
     * Get the product that owns the checkout
     */
    public function product()
    {
        return $this->belongsTo('App\product');
    }
}
