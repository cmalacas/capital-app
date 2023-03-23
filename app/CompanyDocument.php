<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
        'deleted' => 0
    ];

    public function officer() {
        return $this->belongsTo('App\Director', 'officer_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
