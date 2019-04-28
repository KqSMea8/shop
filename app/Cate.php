<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    protected $table = 'shop_order';
    protected $primaryKey = 'order_id';
    public $timestamps = 'false';
}
