<?php

namespace App\Http\Controllers\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Cate as Cate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //购物车列表
    public function index(Request $request)
    {
        // $table=cache('table');
        // $count=cache('count');
        // // var_dump($table);
        // // var_dump($count);
        // if(!$table || !$count){
        //     echo '李帅真丑';
            $where=[
                'cart_status'=>1,
                'user_id'=>session('userInfo.user_id')
            ];
            $table=DB::table('shop_care')
                ->join('shop_goods','shop_goods.goods_id','=','shop_care.goods_id')
                ->where($where)
                ->get();
            //求总条数

            $count=count($table);
            //  dd($count);
        //     cache(['table'=>$table],60*24);
        //     cache(['count'=>$count],60*24);
        // }
       
        return view('cart/car',['res'=>$table],['count'=>$count]);
    }
    //去结算
    public function pay(Request $request)
    {
        // $addressInfo=cache('addressInfo');
        // $res=cache('res');
        // $priceInfo=cache('priceInfo');
        // // cache()->flush();
        // // var_dump($addressInfo);
        // if(!$addressInfo || !$res || !$priceInfo){
        //     echo '李帅真丑';
            $data=$request->input();
            $goods=implode($data);
            $goods_id=explode(',',$goods);
            $userwhere=[
                'user_id'=>session('userInfo.user_id'),
                'cart_status'=>1
            ];

            $res=DB::table('shop_care')
                ->join('shop_goods','shop_goods.goods_id','=','shop_care.goods_id')
                ->where($userwhere)
                ->whereIn('shop_care.goods_id',$goods_id)
                ->get();
    //        dd($res);
            $priceInfo=0;
            foreach ($res as $k=>$v){
                $priceInfo=$priceInfo+$v->self_price*$v->buy_number;
            }
            $where=[
                'user_id'=>session('userInfo.user_id'),
                'address_status'=>1
            ];
            $addressInfo=DB::table('shop_address')->where($where)->get();
        //     cache(['addressInfo'=>$addressInfo],60*24);
        //     cache(['res'=>$res],60*24);
        //     cache(['priceInfo'=>$priceInfo],60*24);
        // }
       
        return view('cart/pay',['addressInfo'=>$addressInfo],['res'=>$res,'priceInfo'=>$priceInfo]);
    }
    //改变加减数量
    public function chacknum(Request $request){
        $buy_number=$request->input('buy_number');
        $goods_id=$request->input('goods_id');
        // dd($buy_number);
        $user_where=[
            'user_id'=>session('userInfo.user_id'),
            'goods_id'=>$goods_id
        ];
        $buy_where=[
            'buy_number'=>$buy_number
        ];
        // dd($user_where);
        $res=DB::table('shop_care')->where($user_where)->update($buy_where);
    }
    //删除
    public function del(Request $request){
        $goods_id=request()->input('goods_id');

        $user_id=session('userInfo.user_id');

        $where=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ];
        $table=DB::table('shop_care')->where($where)->delete();
        if($table){
            $this->fial('删除成功');
        }else{
            $this->errores('删除失败');

        }



    }
    //清空购物车
    public function delchar(Request $request){
        $user_id=session('userInfo.user_id');
        $user_where=[
            'user_id'=>$user_id
        ];
        $res=DB::table('shop_care')->where($user_where)->delete();

        if($res){
            $this->fial('清空购物车成功');

        }else{
            $this->errores('清空失败');

        }

    }
    //购物车总价
    public function getCountPrice(Request $request){
        $data=request()->input();


        $array=implode($data);
        $goods_id=explode(',',$array);
        // dd($goods_id);
        $user_id=session('userInfo.user_id');
        $user_where=[
            'user_id'=>$user_id
        ];

        $careInfo=DB::table('shop_care')->where($user_where)->whereIn('goods_id',$goods_id)->get();
        $goodsInfo=DB::table('shop_goods')->whereIn('goods_id',$goods_id)->get();
        $pricecount=0;
        foreach($careInfo as $k=>$v){
            foreach($goodsInfo as $kay=>$val){
                if($v->goods_id==$val->goods_id){
                    $pricecount=$pricecount+$v->buy_number*$val->self_price;
                }
            }
        }
        return $pricecount;

    }
    //判断是否登录
    public function checkLogin(Request $request){
        $user_id=!\Session::get('userInfo');
        // dd($user_id);
        echo json_encode(['login_status'=>$user_id]);
    }
    
    //提交订单
    public function submitform(Request $request){
        $goods_id=$request->input('goods_id');
        $goods_id=explode(',',$goods_id);
        $address_id=$request->input('address_id');
        $pay_type=$request->input('pay_type');
        $order_text=$request->input('order_text');
        //
        DB::beginTransaction();
        //添加订单表
        $priceCount=$this->priceCount($goods_id);
//        dd($priceCount);
        $orderInfo=[
            'order_no'=>time().rand(100000,999999),
            'user_id'=>session('userInfo.user_id'),
            'order_amout'=>$priceCount,
            'pay_type'=>$pay_type,
            'create_time'=>time(),
            'update_time'=>time(),
            'order_text'=>$order_text
        ];
        // dd($orderInfo);
        $order_id=DB::table('shop_order')->insertGetId($orderInfo);
        //添加订单商品表
        $goodswhere=[
            'user_id'=>session('userInfo.user_id'),
            'cart_status'=>1,
        ];
//        dd($goodswhere);
        $goodsInfo = DB::table('shop_care')
            ->join('shop_goods', 'shop_care.goods_id', '=', 'shop_goods.goods_id')
            ->where($goodswhere)
            ->whereIn('shop_care.goods_id',$goods_id)
            ->get()
            ->toArray();
        $goodsorder=[];
        $goodsorder=$this->goodsorder($goodsInfo,$order_id);
        $res2=DB::table('shop_detail')->insert($goodsorder);
//        dd($res2);
        //添加订单地址表
        $addresswhere=[
            'address_id'=>$address_id
        ];
        $addressInfo=DB::table('shop_address')->where($addresswhere)->first();
//        dd($addressInfo);
//            dd($order_id);
        $addressInfo->order_id=$order_id;

        unset($addressInfo->is_default);
        unset($addressInfo->address_status);
        unset($addressInfo->address_id);
        $addInfo=[];
        foreach($addressInfo as $k=>$v){
            $addInfo[$k]=$v;
        }
        $res3=DB::table('shop_order_address')->insert($addInfo);
//        print_r($res3);die;
        //清除购物车
        $res4=DB::table('shop_care')
            ->where('user_id',session('userInfo.user_id'))
            ->whereIn('goods_id',$goods_id)
            ->delete();
        //减少库存
//        dd($goodsInfo);
        foreach($goodsInfo as $k=>$v){
            $goodsWhere=[
                'goods_id'=>$v->goods_id
            ];
            $updateInfo=[
                'goods_num'=>$v->goods_num-$v->buy_number
            ];
            $res5=DB::table('shop_goods')->where($goodsWhere)->update($updateInfo);
        }
        if($res2&&$res3&&$res4&&$res5){
            DB::commit();
            session(['order_id'=>$order_id]);
                 $this->fial('下单成功');
        }else{
            DB::rollBack();
            $this->fial('下单失败');
        }
    }
    //完成订单
    public function success()
    {   
        $cate_model=new cate;
        $order_id=request()->session('order_id');
        //var_dump($order_id);die;
        
        $res=DB::table('shop_order')->orderby('order_id','desc')->first();
        // if($res){
        //     $this->fial('下单成功');
        // }else{
        //     $this->fial('下单失败');
        // }
    //    dd($res);
        return view('cart/success',['res'=>$res]);
    }
    //添加订单商品信息
    public function goodsorder($goodsInfo,$order_id){
        foreach($goodsInfo as $k=>$v){
//            var_dump($v);die;
            $goodsInfo[$k]->order_id=$order_id;
            $goodsInfo[$k]->user_id=session('userInfo.user_id');
            $goodsInfo[$k]->goods_price=$v->self_price*$v->buy_number;
//            dd($goodsInfo);
            foreach($v as $key=>$val){
                $goodsorder[$k][$key]=$val;
                unset($goodsorder[$k]['cart_status']);
                unset($goodsorder[$k]['is_new']);
                unset($goodsorder[$k]['is_best']);
                unset($goodsorder[$k]['is_hot']);
                unset($goodsorder[$k]['is_up']);
                unset($goodsorder[$k]['goods_imgs']);
                unset($goodsorder[$k]['goods_num']);
                unset($goodsorder[$k]['self_price']);
                unset($goodsorder[$k]['market_price']);
                unset($goodsorder[$k]['cart_id']);
                unset($goodsorder[$k]['goods_desc']);
                unset($goodsorder[$k]['goods_score']);
                unset($goodsorder[$k]['brand_id']);
                unset($goodsorder[$k]['cate_id']);
                unset($goodsorder[$k]['care_id']);
                unset($goodsorder[$k]['update_time']);

                $goodsorder[$k]['create_time']=time();
            }
        }
        return $goodsorder;
    }
    //总价
    public function priceCount($goods_id){
        $goodswhere=[
            'user_id'=>session('userInfo.user_id'),
            'cart_status'=>1,
        ];
//        dd($goodswhere);
        $Info = DB::table('shop_care')
            ->join('shop_goods', 'shop_care.goods_id', '=', 'shop_goods.goods_id')
            ->where($goodswhere)
            ->whereIn('shop_care.goods_id',$goods_id)
            ->get();
//        dd($Info);
        if(!empty($Info)){
            $priceCount=0;
            foreach($Info as $k=>$v){
                $priceCount+=$v->buy_number*$v->self_price;
            }
        }
        return $priceCount;
    }
    //H5端
    public function aliyun($order_no){
        if(!$order_no){
//           return redirect('car/success')->with('没有此订单信息');
        }
        //根据订单号获取订单信息  订单金额
        $orderInfo=DB::table('shop_order')->select(['order_amout','order_no'])->where('order_no',$order_no)->first();
        if(!$orderInfo->order_amout<=0){
//            return redirect('car/success')->with('此订单无效');
        }
        require_once app_path( 'libs/pagepay/service/AlipayTradeService.php' );
        require_once app_path( 'libs/pagepay/buildermodel/AlipayTradeWapPayContentBuilder.php' );


        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($order_no);

        //订单名称，必填
        $subject = '帅康科技有限公司';

        //付款金额，必填
        $total_amount = $orderInfo->order_amout;

        //商品描述，可空
        $body ='yyy';

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService(config('alipay'));
        $result=$payResponse->wapPay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));

        return ;
    }
    //立即支付PC端
    public function alipay($order_no){
        if(!$order_no){
//          return redirect('car/success')->with('没有此订单信息');
        }
        //根据订单号获取订单信息  订单金额
        $orderInfo=DB::table('shop_order')->select(['order_amout','order_no'])->where('order_no',$order_no)->first();
        if(!$orderInfo->order_amout<=0){
//            return redirect('car/success')->with('此订单无效');
        }
        require_once app_path('libs\pagepay\service\AlipayTradeService.php' );
        require_once app_path('libs\pagepay\buildermodel\AlipayTradePagePayContentBuilder.php');

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($order_no);

        //订单名称，必填
        $subject = '测试';

        //付款金额，必填
        $total_amount = $orderInfo->order_amout;

        //商品描述，可空
        $body = '测试';

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService(config('alipay'));

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));

        //输出表单
        var_dump($response);

    }
    //同步提示
    public function returntrue(){
        return redirect('/success.html');
    }
    //支付异步通知
    public function returnfalse(){
        $post=json_encode($_POST);
        Log::channel('key')->info($post);
    }
}
