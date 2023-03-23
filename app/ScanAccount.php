<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScanAccount extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
        'order_id' => 0,
        'order_type' => 0,
        'type' => 0,
        'user_id' => 0,
        'debit_quantity' => 0,
        'credit_quantity' => 0,
        'total_quantity' => 0
    ];

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function virtual_account() {
        return $this->hasOne('App\VirtualScanAccount', 'scan_account_id');
    }
}
