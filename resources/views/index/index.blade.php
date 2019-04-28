
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
<body>
    <div class="maincont">
     <div class="head-top">
      <img src="images/tioomg.jpg" />
      <dl>
       <dt><a href="user.html"><img src="images/touxiang.jpg" /></a></dt>
       <dd>
        <h1 class="username">三级分销终身荣誉会员</h1>
        <ul>
         <li><a href="prolist.html"><strong>34</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="/erma"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
      
     </div><!--head-top/-->
     
     <form action="#" method="get" class="search">
      <input type="text" class="seaText fl" />
      <input type="button" value="搜索" id="sou" class="seaSub fr" />
     </form><!--search/-->
     
    <ul class="reg-login-click">
        @if(session('userInfo')!=null)
        @else
            <li><a href="login.html">登录</a></li>
            <li><a href="reg.html" class="rlbg">注册</a></li>
        @endif
        <div class="clearfix"></div>
        
    </ul><!--reg-login-click/-->
    <img src="images/image3.jpg" />

    <ul class="pronav">
        <li><a href="proinfo.html?goods_id=5">黑鲨顶级游戏手机</a></li>
        <li><a href="proinfo.html?goods_id=6">正牌曲面电视</a></li>
        <li><a href="proinfo.html?goods_id=7">格力中央空调</a></li>
        <li><a href="proinfo.html?goods_id=8">苹果Xmax手机壳</a></li>
        <div class="clearfix"></div>
    </ul><!--pronav/-->
    <div class="index-pro1">
        @foreach($res as $k=>$v)
            <div class="index-pro1-list">
                <dl>
                    <dt><a href="/proinfo.html?goods_id={{$v->goods_id}}"><img src="http://www.goodsimgs.com/{{$v->goods_img}}" width="100" height="100" /><hr></dt>
                    <dd class="ip-text"><a href="javascript:;">{{$v->goods_name}}</a></dd>
                    <dd class="ip-price"><strong>现价¥{{$v->self_price}}</strong> <span>原价¥{{$v->market_price}}</span></dd>
                </dl>
            </div>
        @endforeach



        <div class="clearfix"></div>
    </div><!--index-pro1/-->
    <div class="prolist">


    </div><!--prolist/-->
    <div class="joins"><a href="fenxiao.html"><img src="images/jrwm.jpg" /></a></div>
    <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>

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
        <dl>
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
<!--焦点轮换-->
<script src="js/jquery.excoloSlider.js"></script>
<script>
    $(function () {
        $("#sliderA").excoloSlider();
       
    });
</script>
</body>
</html>