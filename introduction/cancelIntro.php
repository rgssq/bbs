<?php
require_once('../common.php');
require_once('../dbquery.php');
$response = "";
session_start();
if(isset($_SESSION['employeenum']) && isset($_SESSION['wprivilege']) && isset($_GET['cid']))
{
	
	if(isAuthorized($_SESSION['wprivilege'],$_GET['cid']))
	{
		$db = new database();
		$rltField = array('tid');
		$conField = array('cid');
		$conOperator = array('=');
		$conValue = array($_GET['cid']);
	    $result = $db->singleQueryDB('introduction',$conField,$conOperator,$conValue);
		$tid = $result[0]['tid'];
		$db->singleDeleteDB('introduction',$conField,$conOperator,$conValue);

		$conField = array('tid');
		$conValue = array($tid);
		$db->singleDeleteDB('topic',$conField,$conOperator,$conValue);
		$response = $_GET['cid'];
	}
}
echo $response;
?>