<?php
require_once('../common.php');
require_once('../dbquery.php');
/**
	*status 1 �ȴ����
	*status 2 �����Ѿ�ע��
	*status 3 �������벻һ��
	*status 4 ע����Ϣû����ȫ
	**/
$status = 0;
if(isset($_POST['employeeNum'])&&isset($_POST['employeeName'])&&isset($_POST['pwd'])&&isset($_POST['pwdre']))
{
	$db = new database();
	$tableName = 'person';
	if($db)
	{
		$qryField=array('id');
		$conField=array('employeenum');
		$conOperator=array('=');
		$conValue=array($_POST['employeeNum']);
		$result=$db->singleQueryDB($tableName,$qryField,$conField,$conOperator,$conValue);
		if($result)
		{
			$status=2;
		}
		else if($_POST['pwd'] != $_POST['pwdre'])
		{
			$status=3;
		}
		else
		{
			$content=array('employeenum'=>$_POST['employeeNum'],
							'name'=>$_POST['employeeName'],
							'pwd'=>md5($_POST['pwd']));
			$result=$db->insertDB($tableName,$content);
			$status = 1;
		}
	}
}
else
{
	$status=4;
}

$url = "./login_check.php?register=".urlencode('ע��')."&status=".$status;
			redirect($url);
?>