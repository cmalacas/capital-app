<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceMaster extends Model
{
    protected $table = 'invoice_master';

    protected $primaryKey = 'invoice_id';

    public function orders() {
        return $this->hasMany('App\InvoiceData', 'invoice_id');
    }

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function data() {
        return $this->hasMany('App\InvoiceData', 'invoice_id');
    }

}
