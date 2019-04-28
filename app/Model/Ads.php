<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ads extends Model
{
    use SoftDeletes;
    //数据库的链接
    protected $table = 'ads';
    public $timestamps=false; 
    // protected $dates = ['deleted_at'];

}
