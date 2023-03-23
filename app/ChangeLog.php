<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $attributes = [
        'status' => 0
    ];

    
}
