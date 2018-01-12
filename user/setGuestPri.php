<?php
require_once('../common.php');
require_once('../dbquery.php');
$db = new database();
if(isset($_GET['readPri']))
{
	$db->emptyTable('readctl');
	$read=explode(" ",$_GET['readPri']);
	$count = 0;
	
	foreach($read as $key=>$value)
	{
		$count++;
		if($value == "1")
		{
			$content=array('cid' => $count);
			$db->insertDB('readctl',$content);
		}
	}
}
?>