<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualAccount extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
        'vat' => 0,
        'total_amount' => 0,
        'payment_status' => 0,
        'order_id' => 0,
        'user_id' => 0,
        'debit_amount' => 0
    ];

    public function order() {
        return $this->belongsTo('App\Order');
    }

    public function client() {
        return $this->belongsTo('App\Client');
    }
}
