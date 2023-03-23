<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public $timestamps = false;

    protected $attributes = [
        'type' => 0
    ];
}
