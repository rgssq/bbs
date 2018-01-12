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
	/*此处后来添加权限控制，只有有权限的才能访问上传hotnews*/
	//hotNews的频道号
	$cid = 1;
    if(isAuthorized($_SESSION['wprivilege'],$cid))
	{
		require_once('upload.htm');
		require_once('add_topic.htm');
	}
?>