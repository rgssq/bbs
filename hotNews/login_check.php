<html>
<head>
<style type="text/css">
</style>
</head>
<body>
<?php
require_once('../common.php');
require_once('../dbquery.php');
$homepage="index.php";
//ע�᷵����Ϣ

if(isset($_GET['register']) && (urldecode($_GET['register'])== "ע��"))
{
	if(isset($_GET['status']) && ($_GET['status'] == 1))
	//����ע�ᣬ�ȴ����
	{
		require_once('register_header1.htm');
		header("refresh:2;".$homepage);
	}
	//�����ظ�
	else if(isset($_GET['status']) && ($_GET['status'] == 2))
	{
		require_once('register_header2.htm');
		require_once('register.htm');
	}
	//�������벻һ��
	else if(isset($_GET['status']) && ($_GET['status'] == 3))
	{
		require_once('register_header3.htm');
		require_once('register.htm');
	}
	//û����ȫ����
	else if(isset($_GET['status']) && ($_GET['status'] == 4))
	{
		require_once('register_header4.htm');
		require_once('register.htm');
	}
}
//�ض���ע�����
else if(isset($_POST['register']) && ($_POST['register'] == "ע��"))
{
	require_once('register_header_default.htm');
	require_once('register.htm');
}
//����ɹ����ض��򵽷���ǰ�Ľ���
else if(isset($_POST['login']) && $_POST['login'] == "��¼")
{
	if(isset($_POST['employeeNum'])&&isset($_POST['pwd']))
	{
		$db = new database();
		$tableName = 'person';
		if($db)
		{
			$rltField=array('pwd','name','wprivilege','rprivilege');
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
						redirect($homepage);
				}
				else
				{
					echo "�������";
				}
			}
			else if(count($result) == 0)
			{
				echo "�޴��û�";
			}
			else
			{
				echo "database error,multi user";
			}
		}
	}
	else
		//���Ż�������ûȫ
	{
		header("refresh:2;index.php");
	}
	
	
}
?>
</body>
</html>