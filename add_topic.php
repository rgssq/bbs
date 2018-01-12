<?php
require_once('common.php');
require_once('dbquery.php');
session_start();
$db = new database();
$date=date("Y-m-d");
$time=date("YmdHis");
//上传附件相应的处理
if(isset($_POST['submit']) && ($_POST['submit'] == "上传"))
{
	//注意此处定义上传目录，\ 应该为DIRECTORY_SEPARATOR,同时也主要注意不能递归创建目录
	$upload=".".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR;

	$path=__FILE__;
	$position = strrpos($path,'\\');
	//echo $position;
	//echo strlen($path);
	//echo substr(__FILE__,0,$position);

	//if ((($_FILES["file"]["type"] == "image/gif")
	//|| ($_FILES["file"]["type"] == "image/jpeg")
	//|| ($_FILES["file"]["type"] == "image/pjpeg")))
	 // {
	  if ($_FILES["file"]["error"] > 0)
		{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
	  else
		{
		  
		  $dir=".\upload".DIRECTORY_SEPARATOR.$date.DIRECTORY_SEPARATOR;
		  if(!file_exists($dir))
		  {
			  mkdir($dir,true);
		  }
		  $fullname=$_FILES["file"]["name"];
		  //。出现的最后位置
		  $pos = strrpos($fullname,'.');
		  $ext=substr($fullname,$pos);
		  $name=substr($fullname,0,$pos);
		  

		  $name=$name.$time.$ext;
		if (file_exists($dir.$name))
		  {
		  echo $_FILES["file"]["name"] . " already exists. ";
		  }
		else
		  {
		  
		  move_uploaded_file($_FILES["file"]["tmp_name"],
		  $dir.$name);
		  //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
		  $src=$_SESSION['tsrc'];
		  $count=0;
		  if($src == "")
		  {
			  $src=$dir.$name;
			  $count=1;
		  }
		  else
		  {
			  $count=count(explode(";",$src))+1;
			  $src=$src.";".$dir.$name; 
		  }
		  //不使用$count，给附件计数
		  $src=$src."|附件".":".$_POST['tRscDes'];
		  $_SESSION['tsrc']=$src;
		  //此处保存tcontent
		  if(isset($_POST['tcontent']))
			  $_SESSION['tcontent']=$_POST['tcontent'];
		  //此处保存ttitle
		  if(isset($_POST['ttitle']))
			  $_SESSION['ttitle']=$_POST['ttitle'];
		  
          $_SESSION['tjump']=true;
		  }
		}
}
else if(isset($_POST['addTopic']) && ($_POST['addTopic'] == '发帖'))
{	
	if($_POST['ttitle'] == "")
	{
		$_SESSION['tcontent']=$_POST['tcontent'];
		$_SESSION['tjump']=true;
	}
	else
	{
		$tcontent = nl2br($_POST['tcontent']);
		//此处存储帖子
		$time=date("Y-m-d H:i:s");
		$content=array(
			'id'=>$_SESSION['employeenum'],
			'cid'=>$_SESSION['cid'],
			'tname'=>$_POST['ttitle'],
			'tcontent'=>$tcontent,
			'tcount'=>0,
			'tdate'=>$time,
			'tip'=>getOnlineIp(),
		);
		$db->insertDB('topic',$content);
		//此处存储在数据库资源的url
		$_SESSION['tjump']=false;
	}
	
}
else
;

if(isset($_SESSION['cid']) && isset($_SESSION['tstart'])&& isset($_SESSION['cname']))
{
  $homepage="channel.php?cid=".$_SESSION['cid']."&cname=".$_SESSION['cname']."&tstart=".$_SESSION['tstart'];
}
else
  $homepage="index.php"; 

redirect($homepage);
?>