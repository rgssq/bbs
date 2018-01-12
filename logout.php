<?php
require_once('common.php');
session_start();
$homepage="index.php";
if(!empty($_SESSION['employeenum']) && $_POST['logout'] == '×¢Ïú')
{
	unset($_SESSION['employeenum']);
	unset($_SESSION['tsrc']);
	unset($_SESSION['wprivilege']);
	unset($_SESSION['rprivilege']);
	if(isset($_SESSION['tid']) && isset($_SESSION['pstart']) )
	{
		$homepage="topic_content.php?tid=".$_SESSION['tid']."&pstart=".$_SESSION['pstart'];
	}
	elseif(isset($_SESSION['cid']) && isset($_SESSION['tstart'])&& isset($_SESSION['cname']))
	{
		$homepage="channel.php?cid=".$_SESSION['cid']."&tstart=".$_SESSION['tstart']."&cname=".$_SESSION['cname'];
	}
	else
		;
	redirect($homepage);
	
}
else
{
	require_once('usrManagement.htm');
}
?>