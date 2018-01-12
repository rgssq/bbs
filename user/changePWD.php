<?php
require_once('../common.php');
require_once('../dbquery.php');
$employeenum = $_POST['employeenum'];
$pwd = $_POST['pwd'];

if((!empty($employeenum)) && (!empty($pwd)))
{
	$db = new database();
	$updateField = array('pwd');
	$updateValue = array(md5($pwd));
	$conField = array('employeenum');
	$conOperator = array('=');
	$conValue = array($employeenum);
	$db->singleUpdateDB('person',$updateField,$updateValue,$conField,$conOperator,$conValue);
	
}
$reponse=$employeenum.$pwd;
echo $reponse;
?>