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
       <h1>收货地址</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="images/lsls.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><a href="address.html" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
       <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">删除信息</a></td>
      </tr>
     </table>
     
     <div class="dingdanlist">
      <table>
       @foreach($res as $k=>$v)
       <tr>
        <td width="50%">
            <input type="checkbox" class="box">
         <h3 id="id" address_id="{{$v->address_id}}">{{$v->address_name}}{{$v->address_tel}}</h3>
         <time>{{$v->province}}{{$v->city}}{{$v->area}}</time>
        </td>
        <td align="right"><a href="update.html?address_id={{$v->address_id}}" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
       </tr>
           @endforeach
      </table>


     </div><!--dingdanlist/-->
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="index.html">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="prolist.html">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl>
      <dl>
       <a href="car.html">
        <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
        <dd>购物车 </dd>
       </a>
      </dl>
      <dl class="ftnavCur">
       <a href="user.html">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
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
        layui.use('layer',function() {
            layer = layui.layer;
            $('.orange').click(function(){
                var _this=$(this);
                var box=$('.box').prop('checked');
                var address_id=$('#id').attr('address_id');
                if(box==true){
                    $.get(
                      "delete",
                        {address_id:address_id},
                        function(res){
                          if(res.code==1){
                              layer.msg(res.font,{icon:res.code});
                              history.go(0);
                          }else{
                              layer.msg(res.font,{icon:res.code});
                          }
                        },'json'
                    );
                }else{
                    layer.msg('请选择要删除的商品',{icon:2});
                }
            })
        })
    })



</script>