<?php
require_once('../common.php');
require_once('../dbquery.php');
session_start();
$_SESSION['cid'] = 1;
$db = new database();
$date=date("Y-m-d");
$time=date("YmdHis");
//�ϴ�������Ӧ�Ĵ���
if(isset($_POST['submit']) && ($_POST['submit'] == "�ϴ�"))
{
	//ע��˴������ϴ�Ŀ¼��\ Ӧ��ΪDIRECTORY_SEPARATOR,ͬʱҲ��Ҫע�ⲻ�ܵݹ鴴��Ŀ¼
	$upload="..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR;

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
		  
		  $dir="..\upload".DIRECTORY_SEPARATOR.$date.DIRECTORY_SEPARATOR;
		  if(!file_exists($dir))
		  {
			  mkdir($dir,true);
		  }
		  $fullname=$_FILES["file"]["name"];
		  //�����ֵ����λ��
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
		  //��ʹ��$count������������
		  $src=$src."|����".":".$_POST['tRscDes'];
		  $_SESSION['tsrc']=$src;
		  //�˴�����tcontent
		  if(isset($_POST['tcontent']))
			  $_SESSION['tcontent']=$_POST['tcontent'];
		  //�˴�����ttitle
		  if(isset($_POST['ttitle']))
			  $_SESSION['ttitle']=$_POST['ttitle'];
		  
          $_SESSION['tjump']=true;
		  }
		}
}
else if(isset($_POST['addTopic']) && ($_POST['addTopic'] == '����'))
{	
	$ttitle=$_POST['ttitle'];
	if(strlen($ttitle) > 0)
	{
		$tcontent = nl2br($_POST['tcontent']);
		//�˴��洢����
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
		$tid = $db->getID();
		if(isset($_SESSION['hotPic']))
		{
			$content=array(
				'tid'=>$tid,
				'hurl'=>$_SESSION['hotPic'],
			);
			$db->insertDB('hotnews',$content);
		}
		//�˴��洢�����ݿ���Դ��url
		$_SESSION['tjump']=false;
	}
	else
	{
		

		$_SESSION['tcontent']=$_POST['tcontent'];
		$_SESSION['tjump']=true;
	}
	
}
else
;

if(isset($_SESSION['cid']) )
{
  $homepage="index.php?cid=".$_SESSION['cid'];
}
else
  $homepage="index.php"; 

redirect($homepage);
?>