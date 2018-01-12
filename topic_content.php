<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<style type="text/css">
body {
text-align:center;
font:12px/1.6em Helvetica, Arial, sans-serif;}
#main { width:1066px;margin-left:auto;margin-right:auto;text-align:left;align:center;
		border-style:none;
		border-left-style:solid;border-left-color:#DEDEDE;
		border-right-style:solid;border-right-color:#DEDEDE;
		border-bottom-style:solid;border-bottom-color:#DEDEDE;}
.clear {
  clear: both;
  }
#content{
}
#divleft{
float:left;
border-right:2px solid #DEDEDE;
border-top:2px solid #DEDEDE;
border-bottom:1px solid #DEDEDE;
width:900px;
}
#tname
{
width:890px;

padding:2px;
margin:2px;
font-size:24px;
font-weight:bold;
align:center;

}
#tdate
{
float:right;
clear:both;
}
#tlSep
{
width:900px;
border-top:2px solid #DEDEDE;
}
#tcontent
{
text-align:left;
font-size:14px;
width:870px;
padding:10px;
margin:2px;
float:left;
clear:both;
}
#timg
{

width:300px;
height:auto;
}
#pname
{
text-align:left;
width:890px;
padding:2px;
margin:2px;
font-size:16px;
font-weight:bold;
}
#pdate
{
float:right;
clear:both;
}
#pcontent
{
text-align:left;
font-size:13px;
width:870px;
padding:10px;
margin:2px;
float:left;
clear:both;
}
#pSep
{
width:900px;
border-top:2px solid #DEDEDE;

}


#divright
{
float:right;border:1px solid #DEDEDE;
width:160px;
}
</style> 

</head>
<body >
<?php
require_once('common.php');
require_once('dbquery.php');
session_start();
?>
<div id='main'>
<?php 
	require_once('menu.htm');
?>
<div id='content'>
<div id='divleft'>
<?php
if(isset($_GET['tid']))
{
	$_SESSION['tid']=$_GET['tid'];
	$_SESSION['pstart']=$_GET['pstart'];
	$db = new database();
	$query = "select cid from topic where tid=".$_SESSION['tid'];
	$result = $db->queryDB('topic',$query);
	$_SESSION['cid']= $result[0]['cid'];
?>
<div>
<?php
	
		require_once('topic_content.htm');
?>
</div>
<div id="tlSep">
</div>
<div>
<?php
	if(isAuthorized($_SESSION['rprivilege'],$_SESSION['cid']))
		require_once('post_content.htm');
?>
</div>
<div>
<?php
	if(isAuthorized($_SESSION['wprivilege'],$_SESSION['cid']))
		require_once('add_post.htm');
}
?>
</div>
</div>
<div id='divright'>
<?php 
	if(!empty($_SESSION['employeenum']))
	{
		require_once('logined.htm');
	}
	else
	{
		require_once('login.htm');
	}

?>
<div id="empty"></div>
</div>
</div>
</div>
</body>
</html>