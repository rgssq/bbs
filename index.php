<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<style type="text/css">
 

   


#list {list-style-type:none; padding:0; margin:0 0 0 0;width:900px; text-align:left;}
#list .left{float:left; width:387px;}
#list .right{float:left;width:254px;}
body {text-align:center;}
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
#divright
{
float:right;border:1px solid #DEDEDE;
width:160px;
}
</style> 

</head>
<body >

<div id="main">
<?php
	
	require_once('menu.htm');
?>
<div id="content">
<div id="divleft">
<ul id="list">
<li class="left">
<?php require_once('hotPic.htm');?>
</li>
<li class="right">
<?php require_once('pannel1.htm');?>
</li>
<li class="right">
<?php require_once('pannel2.htm');?>
</li>

</ul>
<ul id="list">

<li class="right">
<?php require_once('pannel3.htm');?>
</li>
</ul>
</div>
<div id="divright">
<?php
	session_start();
	unset($_SESSION['cid']);
	if(empty($_SESSION['employeenum']))
	{
		
		require_once( 'login.htm');
	}
	else
	{	
		require_once('logined.htm');
	}
?>

</div>
<div class="clear"></div>
</div>
</div>


</body>
</html>