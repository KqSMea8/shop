<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'shop_user';
    protected $primaryKey = 'user_id';
    public $timestamps = 'false';
}
