<?php
   // Edit upload location here
   $destination_path = ".".DIRECTORY_SEPARATOR.pic.DIRECTORY_SEPARATOR;

   $result = 0;
   
    $target_path = $destination_path . basename( $_FILES['myfile']['name']);
    $time=date("YmdHis");
	$pos = strrpos($target_path,'.');
    $ext=substr($target_path,$pos);
    $name=substr($target_path,0,$pos);
    $target_path=$name.$time.$ext;
   if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
      $trans=str_replace("\\","\\\\",$target_path);
	  session_start();
      $src=$_SESSION['tsrc'];
		  
		  if($src == "")
		  {
			  $src=".\\hotNews".substr($target_path,1);
			  
		  }
		  else
		  {
			  
			  $src=$src.";".".\\hotNews".substr($target_path,1);
		  }
		  //不使用$count，给附件计数
		  $src=$src."|附件".":".$_POST['tRscDes'];
		  $_SESSION['tsrc']=".".$src;
		  //此处保存tcontent
		  if(isset($_POST['tcontent']))
			  $_SESSION['tcontent']=$_POST['tcontent'];
		  //此处保存ttitle
		  if(isset($_POST['ttitle']))
			  $_SESSION['ttitle']=$_POST['ttitle'];
		  
          $_SESSION['tjump']=true;
		  $_SESSION['icUrl']=$trans;
   }
   
		  
?>

<script language="javascript" type="text/javascript">
	var result = "<?php echo $trans; ?>";
	window.top.window.stopUpload(result);
</script>   
