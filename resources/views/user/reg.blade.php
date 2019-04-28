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
    <style>
    #inuser_code{
        width:70px;
        border-radius:50px;
        border:1px solid red;
        background:red;
    }
  
  
  </style>
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
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
     <img src="images/top.jpg" width="360px" / >

     </div><!--head-top/-->
     <form action="regdo" method="post" class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="login.html">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList">
         <input type="text" name="user_email" placeholder="输入手机号码或者邮箱号" id="user_email"/>
      </div>
       <div class="lrList2">
         <input type="text" name="user_code" placeholder="输入短信验证码" id="user_code"/>
         <input type="button" value="获取验证码" id="inuser_code" >
        </div>
       <div class="lrList"><input type="password" name="user_pwd" id="user_pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="password" name="pwd" id="repwd" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="立即注册" id="submit"/>
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
  layui.use(['layer'],function(){
    var layer=layui.layer;
   
  $(document).on('click','#inuser_code',function(){
        var user_emailF=false;
        var user_email =$('#user_email').val();
        var reg = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/; 
        var are = /^1[34578]\d{9}$/;
        var _this=$(this);
        if(user_email==''){
          layer.msg('账号必填',{icon:2});
          return false;
        }else if(!reg.test(user_email) && !are.test(user_email)){
          layer.msg('邮箱或手机号格式不正确',{icon:2});
          return false;
        }else{
          $.ajax({
						type:'post',
						url:"checkemail",
						data:{user_email:user_email},
						async:false,
						success:function(res){
						if(res==1){
                           layer.msg('邮箱或手机号以存在',{icon:2});
							return user_emailF=false; 
						}else{
							return user_emailF=true; 
						}
					},
					dataType:'json'
				
					})
					if(user_emailF==false){
						return user_emailF;
        }
        }
        $.post(
            'sendemail',
            {user_email:user_email},
            function(res){
               if(res.code==1){
                   layer.msg(res.font,{icon:res.code});
               }else{
                   layer.msg(res.font,{icon:res.code});

               }
            },'json'
        )
   }) 
   $('#submit').click(function(){
    var user_email =$('#user_email').val();

  
         //验证码
         var user_code=$('#user_code').val();
      //验证码
      if(user_code==''){
        layer.msg('验证码必填',{icon:2});
        return false;
      }
      //密码
      var user_pwd=$('#user_pwd').val();
      var user_pwdreg=/^(\w){6,20}$/;  
      if(user_pwd==''){
        layer.msg('密码必填',{icon:2});
        return false;
      }else if(!user_pwdreg.test(user_pwd)){
        layer.msg('6-20个字母、数字、下划线 ',{icon:2});
        return false;
      }
      //确认密码
      var repwd=$('#repwd').val();
      var reuser_pwdreg=/^(\w){6,20}$/;  
      if(repwd==''){
        layer.msg('确认密码必填',{icon:2});
        return false;
      }else if(!reuser_pwdreg.test(repwd)){
        layer.msg('6-20个字母、数字、下划线 ',{icon:2});
        return false;
      }else if(repwd!=user_pwd){
        layer.msg('确认密码和密码不一致 ',{icon:2});
        return false;
      }
     $.post(
       "regdo",
       {user_email:user_email,user_code:user_code,user_pwd:user_pwd,repwd:repwd},
        function(res){
          // console.log(res);
          if(res==1){
            layer.msg('注册成功',{icon:1});
            location.href="login.html"

          }else{
          layer.msg('验证码错误',{icon:2});
            return false;
          }
        }
    
   )


 
  })
})
})
</script>
