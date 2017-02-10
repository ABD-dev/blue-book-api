<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'description', 'amount_in', 'amount_out', 'value_in', 'value_out', 'expiry_date'];
}
