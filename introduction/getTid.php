<?php
//response = ""无权限或者未登录
//response = 0 没有设为介绍版块
//response != 0 设为介绍版块
require_once('../common.php');
require_once('../dbquery.php');
$response="";
session_start();
if(isset($_SESSION['employeenum']) && isset($_SESSION['wprivilege']))
{
	
	if(isset($_GET['cid']))
	{
		$_SESSION['cid'] = $_GET['cid'];
		if(isAuthorized($_SESSION['wprivilege'],$_GET['cid']))
		{
			$_SESSION['cid'] == $_GET['cid'];
			$db = new database();
			$query = 'select tid from introduction where cid = '.$_GET['cid'];
			$result = $db->queryDB('introduction',$query);
			if(isArray($result))
			{
				$response=$result[0]['tid'];
			}
			else
			{
				$response="0";
			}

		}
		
	}
}
echo $response;
?>