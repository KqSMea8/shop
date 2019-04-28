<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //登陆
    public function login()
    {
        //
        return view('user/login');
    }
    //登录执行
    public function logindo(Request $request){
        $data=$request->input();
        $where=[
            'user_email'=>$data['user_email'],
        ];
        $user_email=DB::table('shop_user')->where($where)->first();
         $pwd=$user_email->user_pwd;
         $user_pwd=decrypt($pwd);
        if(!$user_email){
            $this->errores('用户不存在');
        }else{

            if($user_pwd!=$data['user_pwd']){
               $this->errores('账号或密码错误');
            }
            $userInfo=[
                'user_id'=>$user_email->user_id,
                'user_email'=>$user_email->user_email
            ];
            // dd(session('userInfo'));
            
            if(session('userInfo')==''){
                session(['userInfo'=>$userInfo]);
                $this->fial('登录成功');
            }else{
                $this->errores('你已登录');
            }
           
          
        }
        }
    //注册
    public function reg(Request $request){
        return view('user/reg');
    }
    //邮箱唯一
    public function checkemail(Request $request){
            // echo 111;
        $data=$request->input();
          $where=[
            'user_email'=>$data

          ];
        $res=DB::table('shop_user')->where($where)->first();
        //   dd($res);
        if(empty($res)){
            echo 2;
        }else{
            echo 1;
        }


    }
    //注册执行
    public function regdo(Request $request){
        $code= request()->session()->get('code');
        $data=$request->input();
        $data['user_pwd']=encrypt($data['user_pwd']);
//        dd($data);
        $data['create_time']=time();
        unset($data['repwd']);

        if($data['user_code'] != $code['code']){
            echo 2;
        }else{
            $res =DB::table('shop_user')->insert($data);
            echo 1;
        }
        
        
    }
    //发送验证码
    public function sendemail(Request $request)
    {
        $user_email = request()->input('user_email');
        $code = rand(100000, 999999);
        if(is_numeric($user_email)){
            $host = "http://dingxin.market.alicloudapi.com";
            $path = "/dx/sendSms";
            $method = "POST";
            $appcode = "c9a75dff8e24476c907d2e3460a82d74";
            $headers = array();
            array_push($headers, "Authorization:APPCODE " . $appcode);
            $querys = "mobile=$user_email&param=code%3A$code&tpl_id=TP1711063";
            $bodys = "";
            $url = $host . $path . "?" . $querys;
        
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_FAILONERROR, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            if (1 == strpos("$".$host, "https://"))
            {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            }
            var_dump(curl_exec($curl));
            // dd($curl);
            $email=request()->session()->put('code',$code);
            $flag='';
        }else{
            $flag = Mail::send('user.sendemail',['data' => $code],function($message)use($user_email){
                $message->subject("您的注册信息");
                $message->to($user_email);
            });
            $email=request()->session()->put('code',$code);
        }
        
        
       
        //dd($flag);
        if ($flag == '') {
            session(['code' => ['code' => $code]]);
            $this->fial('发送验证码成功，请查收!');
        } else {
            $this->errores('发送验证码失败，请重试！');
        }
        

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
}