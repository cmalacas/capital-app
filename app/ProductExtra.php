<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductExtra extends Model
{
    public $timestamps = false;

    public function product() {
        return $this->belongsTo('App\Product', 'extra_product_id');
    }
}
