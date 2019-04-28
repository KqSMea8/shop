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
      <img src="images/head.jpg" />
     </div><!--head-top/-->
     <form  class="reg-login">
         <input type="hidden" value="{{$res->address_id}}" id="address_id">
      <div class="lrBox">
       <div class="lrList"><input type="text" value="{{$res->address_name}}" placeholder="收货人" id="address_name" /></div>
       <div class="lrList"><input type="text" value="{{$res->address_detail}}"  placeholder="详细地址" id="address_detail"/></div>

        <select class="area" id="province">
            @foreach($res2 as $k=>$v)
            <option value="{{$v->id}}">{{$v->name}}</option>
            @endforeach
        </select>
        <select class="area" id="city">
            @foreach($res3 as $k=>$v)
                <option value="{{$v->id}}">{{$v->name}}</option>
            @endforeach
        </select>
        <select class="area" id="area">
            @foreach($res4 as $k=>$v)

                <option value="{{$v->id}}">{{$v->name}}</option>
            @endforeach
        </select>

       <div class="lrList"><input type="text" placeholder="手机" id="address_tel"  value="{{$res->address_tel}}"  /></div>
       <div class="lrList2">
           @if($res->is_default==1)
           <input type="checkbox" id="is_default" checked  placeholder="设为默认地址" />
           @else
               <input type="checkbox" id="is_default"  placeholder="设为默认地址" />

           @endif
           <button id="button">设为默认</button></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" id="submit" value="修改" />
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
        layui.use('layer',function(){
            layer=layui.layer;
            //三级联动
            $(document).on('change','.area',function(){
                var _this=$(this);
                var id=_this.val();
                var _option="<option  selected value='0'>请选择</option>"
                _this.nextAll('select').html(_option);
                $.post(
                    "getArea",
                    {id:id},
                    function(res){
                       if(res.code==1){
                            for(var i in res['Area']){
                                _option+="<option value='"+res['Area'][i]['id']+"'>"+res['Area'][i]['name']+"</option>";
                            }
                            _this.next('select').html(_option);
                       }else{
                           layer.msg(res.font,{icon:res.code});
                       }
                        // console.log(_option);

                    },'json'
                )
            })
            //改
            $(document).on('click','#submit',function(){
                var _this=$(this);
                var obj={};
                obj.province=$('#province').val();
                obj.city=$('#city').val();
                obj.area=$('#area').val();
                obj.address_name=$('#address_name').val();
                obj.address_tel=$('#address_tel').val();
                obj.address_detail=$('#address_detail').val();
                obj.address_id=$('#address_id').val();

                if(obj.address_detail==''){
                    layer.msg('请填写详细地址',{icon:2});
                    return false;
                }
                if(obj.address_tel==''){
                    layer.msg('请填写手机号',{icon:2});
                    return false;
                }
                if(obj.address_name==''){
                    layer.msg('请填写姓名',{icon:2});
                    return false;
                }
                    var is_default=$('#is_default').prop('checked');
                        if(is_default==true){
                            obj.is_default=1;
                        }else{
                            obj.is_default=2;
                        }

                if(obj.province==''){
                    layer.msg('请选择完整的配货地区',{icon:2});
                    return false;
                }
                if(obj.city==''){
                    layer.msg('请选择完整的配货地区',{icon:2});
                    return false;
                }
                if(obj.area==''){
                    layer.msg('请选择完整的配货地区',{icon:2});
                    return false;
                }
                $.post(
                    "updatedo",
                        obj,
                    function(res){
                      if(res.code==1){
                              layer.msg(res.font,{icon:res.code,time:3000},function(){
                                  location.href="add-address.html";
                              });
                          }else{
                              layer.msg(res.font,{icon:res.code});
                          }
                    },'json'

                )



                return false;
            })
        })
    })
</script>