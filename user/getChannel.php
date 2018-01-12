<?php
header("Content-Type:text/html;charset=gb2312");
require_once('../dbquery.php');
require_once('../common.php');
$db = new database();
$query = "select * from channel";
$result = $db->queryDB('channel',$query);
$response = "";
foreach($result as $key=>$value)
	$response = $response.$value['cid']." ".$value['cname']." ";

echo $response;

?>