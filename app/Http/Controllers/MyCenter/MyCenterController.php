<?php

namespace App\Http\Controllers\MyCenter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //个人中心
    public function index()
    {
        //
        return view('mycenter/index');
    }
    //我的订单
    public function order()
    {
        //
        // dd(session('userInfo'));

        return view('mycenter/order');

    }
    //我的优惠券
    public function quan()
    {
        //
        return view('mycenter/quan');

    }
    //收获地址管理
    public function addressgun()
    {
//        $this->getAddress();
        $table=DB::table('shop_address')->get()->toArray();
        return view('mycenter/add-address',['res'=>$table]);

    }
    //我的收藏
    public function shoucang()
    {
        //

        return view('mycenter/shoucang');

    }
    //余额体现
    public function tixian()
    {

        //
        return view('mycenter/tixian');

    }
    //退出
    public function quit(Request $request){
        $value = $request->session()->pull('userInfo');
        if($value){
            return redirect('index.html');
        }
    }
    //三级联动
    public function getAreaInfo($pid){
        $where=[
            'pid'=>$pid
        ];
        $areaInfo=DB::table('shop_area')->where($where)->get();
        if(!empty($areaInfo)){
            return $areaInfo;
        }else{
            return false;
        }

    }
    //下一级
    public function getArea(Request $request){

        $id=$request->input();
        if(empty($id)){
            $this->errores('必须选一项');
        };
        $Area=$this->getAreaInfo($id);
        echo json_encode(['Area'=>$Area,'code'=>1]);
    }
    //增加
    public function addressDo(Request $request)
    {
        $data=$request->all();
        $user_id=session('userInfo.user_id');
        $where=[
            'user_id'=>$user_id,
            'create_time'=>time()
        ];
        $data['user_id']=$user_id;
        $data['create_time']=time();
        if($data['is_default']==1){
            //开启事务
            $res1=DB::table('shop_address')->where($where)->update(['is_default'=>2]);//改
            $res2=DB::table('shop_address')->insert($data);//增
            DB::beginTransaction();
            if($res1!==false&&$res2){
                //事务提交
                DB::commit();
                $this->fial('添加成功');
            }else{
                //事务回滚
                DB::rollBack();
                $this->errores('添加失败');
            }
        }else{
            $res2=DB::table('shop_address')->insert($data);//增
            if($res2){
                $this->fial('添加成功');
            }else{
                $this->errores('添加失败');
            }
        }
    }

    //新增收货地址
    public function address(Request $request){

        $area=$this->getAreaInfo(0);

        return view('mycenter/address',['area'=>$area]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $data=$request->input();
        $where=[
            'address_id'=>$data
        ];
        if(empty($data)){
            $this->errores('请正常操作');
        }
        $res=DB::table('shop_address')->where($where)->delete();
        if($res){
            $this->fial('删除成功');
        }else{
            $this->errores('删除失败');
        }
    }
    //修改
    public function update(Request $request){

        $data=$request->input();
        $where=[
            'address_id'=>$data['address_id']
        ];
        $res = DB::table('shop_address')->where($where)->first();
        $aid =  $res->city;
        $bid =  $res->province;

        $res2 = $this-> getAreaInfo(0);
        $res3 = $this-> getAreaInfo($aid);
        $res4 = $this-> getAreaInfo($bid);
        return view('mycenter/update',['res'=>$res,'res2'=>$res2,'res3'=>$res3,'res4'=>$res4]);
    }
    //修改执行
    public function updatedo(Request $request){

        $data=$request->input();
//        dd($data);
        $address_where=[
            'address_id'=>$data['address_id']
        ];
//        dd($address_where);
        $userwhere=[
            'user_id'=>session('userInfo.user_id')
        ];

//        if($data['is_default']==1){
////            echo 1111;exit;
//           //开启事务
//            DB::beginTransaction();
//            $res =DB::table('shop_address')->where($userwhere)->update(['is_default'=>2]);
//            $res1 =DB::table('shop_address')->where($address_where)->update($data);
//            if($res!==false&&$res1){
//                //提交
//                DB::commit();
//                $this->fial('修改成功');
//            }else{
//                //回滚
//                DB::rollBack();
//                $this->errores('修改失败');
//            }
//        }else{
        $reslut =DB::table('shop_address')->where($address_where)->update($data);
        if($reslut){
            $this->fial('修改成功');
        }else{
            $this->errores('修改失败');
        }
//        }


    }




}
