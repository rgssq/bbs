<?php
require_once('common.php');
require_once('dbquery.php');
session_start();
$db = new database();
//�ϴ�������Ӧ�Ĵ���
if(isset($_POST['submit']) && ($_POST['submit'] == "�ϴ�"))
{
	//ע��˴������ϴ�Ŀ¼��\ Ӧ��ΪDIRECTORY_SEPARATOR,ͬʱҲ��Ҫע�ⲻ�ܵݹ鴴��Ŀ¼
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
		  $date=date("Y-m-d");
		  $time=date("YmdHis");
		  $dir=".\upload".DIRECTORY_SEPARATOR.$date.DIRECTORY_SEPARATOR;
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
		  $src=$_SESSION['psrc'];
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
		  $src=$src."|����".":".$_POST['pRscDes'];
		  $_SESSION['psrc']=$src;
		  //�˴�����tcontent
		  if(isset($_POST['pcontent']))
			  $_SESSION['pcontent']=$_POST['pcontent'];
		  //�˴�����ttitle
		  if(isset($_POST['ptitle']))
			  $_SESSION['ptitle']=$_POST['ptitle'];
		  
          $_SESSION['pjump']=true;
		  }
		}
}
else if(isset($_POST['addpost']) && ($_POST['addpost'] == '����'))
{	
	$pcontent=nl2br($_POST['pcontent']);
	//�˴��洢����
	$time=date("Y-m-d H:m:s");	
	$content=array(
		'tid'=>$_SESSION['tid'],
	    'id'=>$_SESSION['employeenum'],
		'cid'=>$_SESSION['cid'],
		'pname'=>$_POST['ptitle'],
		'pcontent'=>$pcontent,
		'pdate'=>$time,
		'pip'=>getOnlineIp(),
    );
    $db->insertDB('post',$content);
	//�˴��洢�����ݿ���Դ��url
		
    $_SESSION['pjump']=false;
}
else
;

if(isset($_SESSION['tid']) && isset($_SESSION['pstart']) )
{
  $homepage="topic_content.php?tid=".$_SESSION['tid']."&pstart=".$_SESSION['pstart'];
}
else
  $homepage="index.php"; 

redirect($homepage);
?>