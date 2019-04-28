<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//微店
Route::get('/index.html','Index\IndexController@index');
//产品详情
// Route::get('/proinfo.html','Index\Indexcontroller@proinfo');
//分销申请
Route::get('/fenxiao.html','Index\IndexController@fenxiao');

//二维码
Route::get('/erma','Index\IndexController@ma');

//所有商品
Route::any('/prolist.html','Goods\GoodsController@index');
//搜索
Route::any('/prolist.html','Goods\GoodsController@index');
//加入购物车
Route::post('/mychar','Goods\GoodsController@mychar');
//库存、价格
Route::post('/price_num','Goods\GoodsController@price_num');
Route::get('/proinfo.html','Goods\GoodsController@proinfo');
Route::get('/goodsInfo','Goods\GoodsController@goodsInfo');





//购物车
Route::get('/car.html','Cart\CartController@index');
//去结算
Route::get('/pay.html','Cart\CartController@pay');
//完成订单
Route::any('/success.html','Cart\CartController@success');
//改变加减数量
Route::post('/chacknum','Cart\CartController@chacknum');
//删除
Route::post('/del','Cart\CartController@del');
//清空购物车
Route::post('/delchar','Cart\CartController@delchar');
//获取购物车总价
Route::post('/getCountPrice','Cart\CartController@getCountPrice');
//判断是否等录
Route::post('/checkLogin','Cart\CartController@checkLogin');
//提交订单
Route::post('/submitform','Cart\CartController@submitform');
//立即支付PC端
Route::any('/car/alipay/{order_no}','Cart\CartController@alipay');
//H5端
Route::any('/car/aliyun/{order_no}','Cart\CartController@aliyun');
//同步提示
Route::any('/returntrue','Cart\CartController@returntrue');
//异步
Route::any('/returnfalse','Cart\CartController@returnfalse');














//个人中心
Route::get('/user.html','MyCenter\MyCenterController@index');
// /新增收货地址
Route::get('/address.html','MyCenter\MyCenterController@address');
//我的订单
Route::get('/order.html','MyCenter\MyCenterController@order');
//我的优惠券
Route::get('/quan.html','MyCenter\MyCenterController@quan');
//收货地址管理
Route::get('/add-address.html','MyCenter\MyCenterController@addressgun');
//我的收藏
Route::get('/shoucang.html','MyCenter\MyCenterController@shoucang');
//我的浏览记录
//余额体现
Route::get('/tixian.html','MyCenter\MyCenterController@tixian');
//删除
Route::get('/delete','MyCenter\MyCenterController@delete');
//退出
Route::get('/quit','MyCenter\MyCenterController@quit');
//修改
Route::get('/update.html','MyCenter\MyCenterController@update');
//修改执行
Route::post('/updatedo','MyCenter\MyCenterController@updatedo');
//下一级
Route::post('/getArea','MyCenter\MyCenterController@getArea');
//增加
Route::post('/addressDo','MyCenter\MyCenterController@addressDo');







//登陆
Route::get('/login.html','User\UserController@login');
//登录执行
Route::post('/logindo','User\UserController@logindo');
Route::get('/create','User\UserController@create');

//注册
Route::get('/reg.html','User\UserController@reg');
//邮箱唯一
Route::post('/checkemail','User\UserController@checkemail');
//注册执行
Route::post('/regdo','User\UserController@regdo');
//邮箱
Route::post('/sendemail','User\UserController@sendemail');



Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
