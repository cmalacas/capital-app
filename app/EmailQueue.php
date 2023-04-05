<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
        'sent_count' => 1,
        'read_status' => 0,
        'sent' => 0,
        'user_id' => 0,
        'client_id' => 0,
        'files' => '',
        'sent_status' => '',       
    ];

    public function company() {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function client() {
        return $this->belongsTo('App\Client', 'client_id');
    }
}
