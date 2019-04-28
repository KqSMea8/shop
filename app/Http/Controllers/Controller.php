<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //正确提示

function fial($value){
    $arr=[
        'font'=>$value,
        'code'=>1
    ];
    echo json_encode($arr);


}
//错误提示
function errores($value){

    $arr=[
        'font'=>$value,
        'code'=>2
    ];
    echo json_encode($arr);exit;


}

//查
function getAddress(){
    $where=[
        'user_id'=>session('userInfo.user_id'),
        'address_status'=>1
    ];
    $addressInfo=DB::table('shop_address')->where($where)->get();
    $area=DB::table('shop_area')->get();
//    //处理收货地区 省市区
//    if(!empty($addressInfo)){
//        foreach($addressInfo as $k=>$v){
//            $addressInfo[$k]->province=$area->where(['id'=>$v->province])->get('name');
//
//        }
//
        return $addressInfo;
//    }else{
//        return false;
//    }

    }




}
