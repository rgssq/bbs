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
	require_once('index.htm');
?>