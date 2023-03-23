<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualScanAccount extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
        'order_id' => 0,
        'type' => 0,    
        'user_id'  => 0,
        'credit_quantity' => 0,
        'debit_quantity' => 0
    ];

    public function scan() {
        return $this->belongsTo('App\Scan');
    }
}
