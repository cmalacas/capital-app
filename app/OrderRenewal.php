<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRenewal extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    public $timestamps = false;
}
