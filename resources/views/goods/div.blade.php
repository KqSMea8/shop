<div class="prolist">
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