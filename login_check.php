<html>
<head>
<style type="text/css">
</style>
</head>
<body>
<?php
require_once('common.php');
require_once('dbquery.php');
$homepage="index.php";
//注册返回消息
if(isset($_GET['register']) && (urldecode($_GET['register'])== "注册"))
{
	if(isset($_GET['status']) && ($_GET['status'] == 1))
	//可以注册，等待审核
	{
		require_once('register_header1.htm');
		header("refresh:2;".$homepage);
	}
	//工号重复
	else if(isset($_GET['status']) && ($_GET['status'] == 2))
	{
		require_once('register_header2.htm');
		require_once('register.htm');
	}
	//两次密码不一样
	else if(isset($_GET['status']) && ($_GET['status'] == 3))
	{
		require_once('register_header3.htm');
		require_once('register.htm');
	}
	//没有填全资料
	else if(isset($_GET['status']) && ($_GET['status'] == 4))
	{
		require_once('register_header4.htm');
		require_once('register.htm');
	}
}
//重定向到注册界面
else if(isset($_POST['register']) && ($_POST['register'] == "注册"))
{
	require_once('register_header_default.htm');
	require_once('register.htm');
}
//如果成功，重定向到访问前的界面
else if(isset($_POST['login']) && $_POST['login'] == "登录")
{
	if(isset($_POST['employeeNum'])&&isset($_POST['pwd']))
	{
		$db = new database();
		$tableName = 'person';
		if($db)
		{
			$rltField=array('pwd','name','checked','wprivilege','rprivilege');
			$qryField=array('employeenum');
			$qryOperator=array('=');
			$qryValue=array($_POST['employeeNum']);
			$result=$db->singleQueryDB($tableName,$rltField,$qryField,$qryOperator,$qryValue);
			if(count($result) == 1)
			{
				if(md5($_POST['pwd']) == $result[0]['pwd'])
				{
					
						session_start();
						$_SESSION['employeenum'] = $_POST['employeeNum'];
						$_SESSION['name'] = $result[0]['name'];
						$_SESSION['ip'] = getOnlineIp();
						$_SESSION['wprivilege'] = $result[0]['wprivilege'];
						$_SESSION['rprivilege'] = $result[0]['rprivilege'];
						if(isset($_SESSION['tid']) && isset($_SESSION['pstart']) )
						{
							$homepage="topic_content.php?tid=".$_SESSION['tid']."&pstart=".$_SESSION['pstart'];
						}
						elseif(isset($_SESSION['cid']) && isset($_SESSION['tstart'])&& isset($_SESSION['cname']))
						{
							$homepage="channel.php?cid=".$_SESSION['cid']."&cname=".$_SESSION['cname']."&tstart=".$_SESSION['tstart'];
						}
						elseif(isset($_SESSION['cid']) && isset($_SESSION['cname']))
							$homepage="channel.php?cid=".$_SESSION['cid']."&cname=".$_SESSION['cname']."&tstart=0";
						else
							;
						redirect($homepage);


				}
				else
				{

					echo "密码错误";

				}
			}
			else if(count($result) == 0)
			{
				echo "不存在此用户";
			}
			else
			{
				echo "数据库错误，多用户";
			}
		}
	}
	else
		//工号或者密码没全
	{
		header("refresh:2;index.php");
	}
	
	
}
?>
</body>
</html>