<?php
require_once('../dbquery.php');
require_once('../common.php');
$employeenum = $_GET['employeenum'];
$readPri = $_GET['readPri'];
$writePri = $_GET['writePri'];

if((!empty($employeenum)) && (!empty($readPri)) && (!empty($writePri)))
{
	$db = new database();
	$updateField = array('rprivilege','wprivilege');
	$updateValue = array($readPri,$writePri);
	$conField = array('employeenum');
	$conOperator = array('=');
	$conValue = array($employeenum);
	$db->singleUpdateDB('person',$updateField,$updateValue,$conField,$conOperator,$conValue);
	
	
}
?>