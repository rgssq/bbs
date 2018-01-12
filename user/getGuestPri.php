<?php
require_once('../dbquery.php');
require_once('../common.php');
$db = new database();
$query = "select cid from readctl";
$result = $db->queryDB('person',$query);
foreach($result as $key=>$value)
	$response=$response.$value['cid']." ";
echo $response;
?>