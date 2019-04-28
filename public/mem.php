<?php
header('content-type:text/html;charset=utf-8');
//$memcache = new Memcache();
//
//$memcache->pconnect('127.0.0.1',11211) or die('memcache connect fail');

//$memcache->add('name','王景涛');
///$memcache->replace('name','马景涛2');

//$memcache->set('num',10);



//$res = $memcache->get('num');

//$memcache->increment('num');
//$memcache->decrement('num',5);
//$res = $memcache->delete('num');
//$name = $memcache->get('name');
//$res = $memcache->getServerStatus('127.0.0.1');
//$memcache->flush();
//var_dump($res);
//var_dump($name);


//展示一个商品品牌信息列表  如果缓存有 则从缓存内读取 否则 连库读取并将结果存入memcache

//当前页
$page = $_GET['page']??1;
//每页显示多少条
$pageSize = 2;
$offset = ($page-1) * $pageSize;

//搜索
$url_name = $_GET['url_name']??'';
$url = '';
$where = ' where 1=1 ';
if( $url_name ){
    $where.= " and url_name like '%$url_name%' ";
    $url .= "&url_name=$url_name";
}

$mem = new Memcache();
$mem->connect('127.0.0.1',11211) or die('connect fail');
//$data = $mem->flush();


$memkey = "brand_".$url_name."_".$page;
$data = $mem->get($memkey);
$totalPage = $mem->get('totalPage');
//var_dump($data);

if(!$data ){

    $conn = mysqli_connect('127.0.0.1','root','root','day7') or die('database connect fail');
    //计算总条数
    $sql = "select count(*) as count from url $where ";
    //echo $sql;
    $res1 = mysqli_query($conn,$sql);
    $count = mysqli_fetch_assoc($res1);
    //总页数
    $totalPage = ceil($count['count']/$pageSize);

    $sql1 = "select * from url $where limit $offset,$pageSize";
    //echo $sql;

    $res = mysqli_query($conn,$sql1);

    $data = mysqli_fetch_all($res,1);
    //print_r($data);
    $mem->set($memkey,$data);
    $mem->set('totalPage',$totalPage);
}
$mem->close();

include('mem.html');


?>