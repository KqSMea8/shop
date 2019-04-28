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
      <img src="images/aa.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange"</strong>{{$count}}件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     
     <div class="dingdanlist">
      <table>
 
       <tr>
        <td colspan="2"><a href="javascript:;"><input type="checkbox" name="1" id="check" /> 全选</a></td>
       <td colspan="1" width="30px" ><input type="button" value="清空购物车" id="delchar"></td>
  
       </tr>
       <tr>
     @foreach($res as $k=>$v)
        <td width="4%"><input type="checkbox" name="1" class="box" /></td>
        <td class="dingimg" width="15%"> <img src="http://www.goodsimgs.com/{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{date("Y-m-d",$v->create_time)}}</time>
        </td>
       
        <td align="right" id="god" buy_number="{{$v->buy_number}} " goods_id="{{$v->goods_id}}" goods_num="{{$v->goods_num}}"><input type="text" class="spinnerExample"  /></td>
        <td ><input type="button" value="删除" id="del"></td>
       </tr>
       <tr>
        <th colspan="4"><strong class="orange">¥{{$v->buy_number * $v->self_price}}</strong></th>
       </tr>
       @endforeach
      </table>
     </div><!--dingdanlist/-->

     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange" id="pric">¥</strong></td>
       <td width="40%"><a href="pay.html" class="jiesuan">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
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
      var spa=$('.spinnerExample');
      spa.each(function(index){
        var buy_number=$(this).parents('td').attr('buy_number');
        $(this).val(buy_number);
      })

      //加号
      $('.increase').click(function(){
        var _this=$(this);
        // console.log(_this);
        var buy_number=_this.parents('td').find('input').val();//获取文本框的数量
        var goods_num=_this.parents('td').attr('goods_num');  //商品表中的库存
        // console.log(goods_num);
        var goods_id=_this.parents('td').attr('goods_id'); //商品表中的id
        if(buy_number>=goods_num){
          _this.prop('disabled',true);
        //  history.go(0);
        }else{
          buy_number=buy_number;
          _this.prev('button').val(buy_number);
          _this.parents('td').find("button").first().prop('disabled',false);
        }
         //从控制器获取小记或者页面中直接计算小计
         $.post(
            "chacknum",
            {goods_id:goods_id,buy_number:buy_number},
            function(res){
              getCountPrice()
            }
         )

      })
      //减号
      $('.decrease').click(function(){
        var _this=$(this);
        var buy_number=_this.parents('td').find('input').val();//获取文本框的数量
        var goods_id=_this.parents('td').attr('goods_id'); //商品表中的id
        if(buy_number<=1){
          _this.prop('disabled',true);
          // history.go(0);

        }else{
          buy_number=buy_number-1;
          _this.prev('button').val(buy_number);
          _this.parents('td').find("button").last().prop('disabled',false);
        }
          //从控制器获取小记或者页面中直接计算小计
          $.post(
            "chacknum",
            {goods_id:goods_id,buy_number:buy_number},
            function(res){
              getCountPrice()
            }
         )
      })

      //获取购物车总价
      function getCountPrice(){
        var box=$('.box');
        var goods_id='';
        box.each(function(index){
            if($(this).prop('checked')==true){
              goods_id+=$(this).parents('tr').children().last().prev().attr('goods_id')+',';
            }
      })
      goods_id=goods_id.substr(0,goods_id.length-1);
      $.post(
        "getCountPrice",
        {goods_id:goods_id},
        function(res){
          $('#pric').text(res);
        }
      )
  } 
      $('.box').click(function(){
        getCountPrice();

      })
      //全选
      $('#check').click(function(){
          var _this=$(this);
         var check= _this.prop('checked');
          $('.box').prop('checked',check);
        getCountPrice();

      })
      //删除
      $('#del').click(function(){
        var box=$('.box').prop('checked');
        // console.log(box);
        var goods_id=$(this).parent('td').prev().attr('goods_id'); 
        // console.log(goods_id);
        layer.confirm('是否确认删除?',{icon:3,title:'提示'},function(index){
                    $.post(
                        "del",
                        {goods_id:goods_id},
                        function(res){
                            if(res.code==1){
                              layer.msg(res.font,{icon:res.code});
                              history.go(0);
                            }
                            getCountPrice();
                        },'json'
                    );
                })



      })
      //清空购物车
      $('#delchar').click(function(){
        layer.confirm('是否清空购物车?',{icon:3,title:'提示'},function(index){
                    $.post(
                        "delchar",
                        function(res){
                            if(res.code==1){
                              layer.msg(res.font,{icon:res.code});
                              history.go(0);
                            }
                            getCountPrice();
                        },'json'
                    );
                })

        })
      })
      //去结算
      $('.jiesuan').click(function(){
        var login=chekLogin();
        // console.log(login);
        if(login==true){
          layer.msg('请先登录',{icon:2,time:2000},function(){
                      location.href="login.html";
             }) 
        }else{
    var box=$('.box');
            var goods_id='';
            box.each(function(index){
          if($(this).prop('checked')==true){
                  goods_id+=$(this).parents('tr').children().last().prev().attr('goods_id')+',';
                }
            })
              goods_id=goods_id.substr(0,goods_id.length-1);
                  if(goods_id==''){
                        layer.msg('至少选择一个商品',{icon:2});
                        return false;
              };
              location.href="pay.html?goods_id="+goods_id;
        }
        return false;
      })
       //判断是否登录
       function chekLogin(){
          var status;
          $.ajax({
              type:'post',
              url:"checkLogin",
              async:false,
              dataType:'json',
              success:function(res){
               status=res.login_status
              // console.log(status);
              }
          })
          return status;
      }



  })
</script>