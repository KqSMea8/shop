<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>董氏高档珠宝</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="images/topbu.jpg" />
     </div><!--head-top/-->
     <div class="dingdanlist">
     
      <table>

            @foreach($addressInfo as $k=>$v)
              <tr>
                  @if($v->is_default==1)
                      <input type="radio" checked  name="is_default"  value="{{$v->address_id}}">
                  @else
                      <td class="dingimg" width="75%"  colspan="2"><a href="address.html">新增收货地址</a></td>
                      <td align="right"><img src="images/jian-new.png" /></td>
                  @endif
              </tr>
          @endforeach
.       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>

       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="2">支付方式</td>
        <td align="right">
            <span class="hui" pay_type="1">支付宝</span>
        </td>
       </tr>
       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>

       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
       <tr><td colspan="3" style="height:10px; background:#fff;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="3">商品清单</td>
       </tr>
          @foreach($res as $k=>$v)
              <tr goods_id="{{$v->goods_id}}" class="goods_id">   <tr>
        <td class="dingimg" width="15%"><img src="http://www.goodsimgs.com/{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{date('Y-m-d',$v->create_time)}}</time>
        </td>
        <td align="right"><span class="qingdan">X {{$v->buy_number}}</span></td>
       </tr>
       <tr>
        <th colspan="3"><strong class="orange">¥{{$v->self_price*$v->buy_number}}</strong></th>
       </tr>
       @endforeach

       <tr>
        <td class="dingimg" width="75%" colspan="2">折扣优惠</td>
        <td align="right"><strong class="green">¥0.00</strong></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="2">免运费</td>
        <td align="right"><strong class="orange">￥0</strong></td>
       </tr>
                <tr>
                    <td class="dingimg" width="75%" colspan="2">订单留言</td>
                    <td align="right">
                        <textarea name="" id="order_text" cols="30" rows="10"></textarea>
                        
                    </td>
                </tr>
      </table>
     </div><!--dingdanlist/-->
     
     
    </div><!--content/-->
    
    <div class="height1"></div>
    <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange">¥{{$priceInfo}}</strong></td>
       <td width="40%"><a href="success.html" class="jiesuan">提交订单</a></td>
      </tr>
     </table>

    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/style.js"></script>
    <!--jq加减-->
    <script src="js/jquery.spinner.js"></script>
    <script src="/layui/layui.js"></script>
    <script>
	$('.spinnerExample').spinner({});
	</script>
  </body>
</html>
<script>
    $(function(){
        layui.use('layer',function(){
            var layer=layui.layer;
            //提交订单
            $('.jiesuan').click(function(){
                //购物车id
                var goods_id='';
                $('.goods_id').each(function(index){
                    goods_id+=$(this).attr('goods_id')+',';
                })
                goods_id=goods_id.substr(0,goods_id.length-1);

                //订单留言
                var order_text=$('#order_text').val();
                //支付方式
               var pay_type =$('.hui').attr('pay_type');

               var address_id=''
                var order_id=''
                //获取收货地址id
                $("input[name='is_default']").each(function(index) {
                    if ($(this).prop('checked') == true) {
                        address_id = $(this).val();
                    }
                })

                $.post(
                    "submitform",
                    {order_id:order_id,goods_id:goods_id,pay_type:pay_type,address_id:address_id,order_text:order_text},
                    function(res){
                        //console.log(res);
                        if(res.code==1){
                            layer.msg(res.font,{icon:res.code,time:3000},function(){
                                location.href="success.html?goods_id";
                            })
                        }else{
                            layer.msg(res.font,{icon:res.code});
                        }
                    },'json'
                        
                )


            })
        })
    });
</script>