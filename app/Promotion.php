<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    /**
     * Get the product that owns the promotion
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
