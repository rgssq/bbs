<?php
require_once('../common.php');
session_start();
	
	if(empty($_SESSION['employeenum']))
	{
		
		require_once( 'login.htm');
	}
	else
	{	
		require_once('logined.htm');
	}
	/*�˴��������Ȩ�޿��ƣ�ֻ����Ȩ�޵Ĳ��ܷ����ϴ�hotnews*/
	//hotNews��Ƶ����
	$cid = 1;
    if(isAuthorized($_SESSION['wprivilege'],$cid))
	{
		require_once('upload.htm');
		require_once('add_topic.htm');
	}
?>