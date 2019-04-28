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
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/response.css" rel="stylesheet">
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

        
      </div>
     </header>
    
     <ul class="pro-select">
      <li id="host" class="pro-selCur css" field="is_new" a_type="1"><a href="javascript:;" >新品</a></li>
      <li id="num"  field="is_best" class="css"  a_type="2"><a href="javascript:;" >精品</a></li>  
      <li id="price" field="is_hot"class="css"  a_type="3"><a href="javascript:;" >热卖</a></li>
     </ul><!--pro-select/-->
     <form action="/prolist.html" method="get" class="search">
        <input type="text" name="sou" value="{{$goods_name}}" class="seaText fl" />
        <input type="submit" value="搜索" class="seaSub fr" />
      </form><!--search/-->
     <div class="prolist" id="div">
      <dl>
      @foreach($res as $k=>$v)
       <dt><a  href="proinfo.html?goods_id={{$v->goods_id}}"><img src="http://www.goodsimgs.com/{{$v->goods_img}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="javascript:;">{{$v->goods_name}}</a></h3>
        <div class="prolist-price"><strong>￥{{$v->self_price}}</strong> <span>¥{{$v->market_price}}</span></div>
        <div class="prolist-yishou"> <em>库存：{{$v->goods_num}}</em></div>
       </dd>
       <div class="clearfix"></div>
       @endforeach
      </dl>
       <div class="clearfix"></div>
      </dl>
     </div><!--prolist/-->
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="index.html">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl class="ftnavCur">
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
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/js/jquery.excoloSlider.js"></script>
    <script src="/layui/layui.js"></script>

    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
  </body>
</html>
<script>
$(function(){
  layui.use('layer',function(){
    var layer=layui.layer;
    //库存
    $('#num').click(function(){
      var _this=$(this);
      _this.addClass('pro-selCur');

        _this.siblings('li').removeClass('pro-selCur');
    })
    //默认
    $('#host').click(function(){
      var _this=$(this);
      _this.addClass('pro-selCur');

        _this.siblings('li').removeClass('pro-selCur');
    })
    //价格
    $('#price').click(function(){
      var _this=$(this);
      _this.addClass('pro-selCur');

        _this.siblings('li').removeClass('pro-selCur');
    })

         $('.css').click(function(){
            var _this = $(this);
            var type = _this.attr('a_type');
            $.get(
                "goodsInfo",
                {type:type},
                function(res){
                  $('#div').html(res);
                  // console.log(res);
                }
            );
         });
        
  })
})

</script>