<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
            'status' => 1,
            'created_user_id' => 1,
            'modified_user_id' => 1,
            'post_code' => '',
            'country' => 'uk',
            'dob' => '1970-01-01',
            'is_director' => 0
        ];

    public function company() {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function client() {
        return $this->belongsTo('App\Client', 'client_id');
    }
}
