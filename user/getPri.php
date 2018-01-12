<?php
require_once('../dbquery.php');
require_once('../common.php');
$id=$_GET['id'];
if($id != 0)
{
	$db = new database();
	$query = "select wprivilege,rprivilege from person where employeenum = ".$id;
	$result = $db->queryDB('person',$query);
	$response =$result[0]['wprivilege']." ".$result[0]['rprivilege'];
	echo $response;
}
else
{
	$response="";
	echo $response;
}
?>