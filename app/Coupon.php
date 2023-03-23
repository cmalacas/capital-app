<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public function orders() {
        return $this->hasMany('App\Order', 'coupon_id');
    }
}
