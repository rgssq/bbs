<?php
//response = ""��Ȩ�޻���δ��¼
//response = 0 û����Ϊ���ܰ��
//response != 0 ��Ϊ���ܰ��
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