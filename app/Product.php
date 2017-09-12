<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Get the promotion record associated with the product
     */
    public function promotion()
    {
        return $this->hasOne('App\Promotion');
    }

    /**
     * Get the checkouts for the product
     */
    public function checkouts()
    {
        return $this->hasMany('App\Checkout');
    }
}
