<?php
require_once('../common.php');
session_start();
$homepage="index.php";
if(!empty($_SESSION['employeenum']) && $_POST['logout'] == '×¢Ïú')
{
	unset($_SESSION['employeenum']);
	unset($_SESSION['tsrc']);
	unset($_SESSION['wprivilege']);
	redirect($homepage);
	
}
?>