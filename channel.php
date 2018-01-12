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
	$homepage='index.php';
	if(isset($_GET['cid'])&&isset($_GET['cname']))
	{
		session_start();
		unset($_SESSION['tid']);
		unset($_SESSION['pstart']);
		$_SESSION['cid']=$_GET['cid'];
		$_SESSION['cname']=$_GET['cname'];
		$_SESSION['tstart']=$_GET['tstart'];
		if(urldecode($_GET['cname']) == '·µ»ØÖ÷Ò³')
		{
			redirect($homepage);
		}
		elseif(urldecode($_GET['cname']) == 'ÂÛÌ³')
		{
			$homepage='forum.htm';
			redirect($homepage);
		}
		else
		{
?>
<div id="main">
<?php
	
	require_once('menu.htm');
?>
<div id="content">
<div id="divleft">
<div>
<?php
		require_once('channel_content.htm');
?>
</div>
<div>
<?php
	$db = new database();
	$query = 'select tid from introduction where cid ='.$_SESSION['cid'];
	$result = $db->queryDB('introduction',$query);
	if(isArray($result))
	{

	}
	else
    {
		

	}
	if(isAuthorized($_SESSION['wprivilege'],$_SESSION['cid']))
			require_once('add_topic.htm');
?>
</div>
</br>
</div>
<div id="divright">
<?php
			if(empty($_SESSION['employeenum']))
			{
				
				require_once( 'login.htm');
			}
			else
			{	
				require_once('logined.htm');
			}
	    }
	}
?>
</div>
<div class="clear"></div>
</div>
</div>
</body>
</html>