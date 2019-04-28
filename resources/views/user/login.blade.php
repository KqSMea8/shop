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
       <h1>会员登陆</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="images/top.jpg" width="360px" / >
     </div><!--head-top/-->
     <form action="logindo" method="post" class="reg-login">
      <h3>快快莱斯go<a class="orange" href="reg.html">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="user_email" id="user_email" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList"><input type="password" name="user_pwd" id="user_pwd" placeholder="输入密码" /></div>
      </div><!--lrBox/-->   
      <div class="lrSub">
       <input type="button" value="立即登录" id="submit" />
      </div>
     </form><!--reg-login/-->
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
    <script src="/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/style.js"></script>
    <script src="/layui/layui.js"></script>
  </body>
</html>

<script>
$(function(){
// alert(1);
    layui.use('layer',function(){
        var layer=layui.layer;
          $('#submit').click(function(){
            var _this=$(this);
            var user_email=$('#user_email').val();
            var user_pwd=$('#user_pwd').val();
            var reg = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/; 
            var are = /^1[34578]\d{9}$/;
            var pwd_reg=/^(\w){6,20}$/;  

            if(user_email==''){
              layer.msg('邮箱或手机号不能为空',{icon:2});
              return false
            }else if(!reg.test(user_email) && !are.test(user_email)){
              layer.msg('邮箱或手机号格式不正确',{icon:2});
              return false;
            }
            if(user_pwd==''){
              layer.msg('密码不能为空',{icon:2});
            }else if(!pwd_reg.test(user_pwd)){
              layer.msg('密码格式不正确',{icon:2});
              return false;
            }
            $.post(
              "logindo", 
              {user_email:user_email,user_pwd:user_pwd},
              function(res){
                  // console.log(res);
                  if(res.code==1){
                  layer.msg(res.font,{icon:res.code,time:3000},function(){
                        location.href="user.html";
                   });
                }else{
                  layer.msg(res.font,{icon:res.code});
                }
              },'json'
        )
    })
  })
})




</script>
