<?php

namespace App\Http\Controllers\Goods;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //
    //所有商品
    public function index(Request $request)
    {
        //
        $query=request()->all();
        
        if($query==''){
            $res=DB::table('shop_goods')->get();
            $goods_name='';
        }else{
            $goods_name=$query['sou']??'';
            $where=[];
            if($goods_name){
                $where[]=['goods_name','like',"%$goods_name%"];
            }
            $res=DB::table('shop_goods')->where($where)->get();
          
        }
        // var_dump($table);exit;
        return view('goods/prolist',compact('res','goods_name'));
  
    }
    //库存、价格
    public function price_num(Request $request){


    }
    //展示详情
    public function proinfo(Request $request){
        $data=$request->input('goods_id');
        // dd($data);
        $where=[
            'goods_id'=>$data
        ];
        $table=DB::table('shop_goods')->where($where)->first();
        $goods_imgs=$table->goods_imgs;
        $goods_imgs=explode('|',ltrim($goods_imgs,'|'));
        // dd($goods_imgs);
    
        return view('goods/proinfo',['res'=>$table,'goods_imgs'=>$goods_imgs]);

    }
    //加入购物车
    public function mychar(Request $request){
        $data =$request->input();
        $buy_num =$request->input('buy_num');
        // dd($buy_num);
        // $buy_num=$request->buy_num;
        $user_id=session('userInfo.user_id');
        $where=[
            'buy_number'=>$data['buy_num'],
            'goods_id'=>$data['goods_id'],
            'user_id'=>$user_id,
            'create_time'=>time(),
            'update_time'=>time(),
        ];
        $user_where=[
            'user_id'=>$user_id,
            'goods_id'=>$data['goods_id']
        ];

        $res=DB::table('shop_care')->where($user_where)->first();
        if(empty($res)){
            $add=DB::table('shop_care')->insert($where);
              if($add){
                $this->fial('加入购物成功');
              }else{
                $this->errores('加入购物车失败');
              }
        }else{
            $goods_where=[
                'goods_id'=>$data['goods_id']
            ];
            $reslut=DB::table('shop_goods')->where($goods_where)->first();
            $goods_num=$reslut->goods_num;
            if($buy_num>$goods_num){
                errores('库存不足');
            }
            $buy_number=$res->buy_number;  
            $update_where=[
                'buy_number'=>$data['buy_num'],
                'update_time'=>time(),
                'buy_number'=>$buy_number+$buy_num
            ];
            $update=DB::table('shop_care')->where($goods_where)->update($update_where);
            if($update){
                $this->fial('加入购物成功');

            }else{
                $this->errores('加入购物车失败');

            }
            


        }
    }
    //新品 精品 热卖
    public function goodsInfo(Request $request){
        $type=$request->type;
        // dd($type);
        if($type==2){
            $goods_where=[
                'is_best'=>1
            ];
            $table=DB::table('shop_goods')->where($goods_where)->get();
            return view('goods/div',['res'=>$table]);
        }else if($type==3){
            $goods_where=[
                'is_hot'=>1
            ];
            $table=DB::table('shop_goods')->where($goods_where)->get();
            return view('goods/div',['res'=>$table]);
        }else if($type==1){
            $goods_where=[
                'is_new'=>1
            ];
            $table=DB::table('shop_goods')->where($goods_where)->get();
            return view('goods/div',['res'=>$table]);

        }
            

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
