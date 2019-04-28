<?php
$memcache = new Memcache();

$memcache->connect('127.0.0.1',11211) or die('不对');
$memcache->add('name','小朱');
var_dump($memcache);
?>