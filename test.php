<html>
<head>
<script language="JavaScript" type="text/JavaScript">
function AddItem(ItemId)
{
document.Form.bible_verse_description.value = document.Form.bible_verse_description.value + '<' + ItemId;
} 

</script>

</head>
<body>
<p>
hello</br>
haha</br>
<form id="Form" name="Form" method="post" action="/jesuswillcome/bible/add-verse.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="100">&nbsp;</td>

<td width="15">&nbsp;</td>
<td width="5">
<a href="#" onclick="AddItem('span style=&quot;color:#ff0000&quot;>');">open span</a>&nbsp; &nbsp; 
<a href="#" onclick="AddItem('/span>');">close span</a> &nbsp; &nbsp;||| &nbsp; &nbsp;

<a href="#" onclick="AddItem('em>');">Open Italic</a>&nbsp;&nbsp; 
<a href="#" onclick="AddItem('/em>');">close italic</a>

<BR></td>
</tr>
<tr>
<td>Verse</td>
<td>&nbsp;</td>
<td><textarea tabindex="1" name="bible_verse_description" cols="45" rows="5" id="bible_verse_description"></textarea></td>
</tr>
</table>
</form>


<!--
<img src='imag0140.jpg' width="150" height="200">
<img width="50px" src=.\upload\2011-04-12\32032119721014024220110412161738.JPG>
-->
</p>

<?php
// We'll be outputting a PDF
//header('Content-type: application/txt');

// It will be called downloaded.pdf
//header('Content-Disposition: attachment; filename="downloaded.php"');

// The PDF source is in original.pdf
//readfile('common.php');
$str = "*";
if ($str == "*")
{
	echo $str;
}
?>
<div style="border:1px solid #DEDEDE;">
<table>
<tr>
<td>
<iframe src="login.htm"></iframe>
</td>
<td>
<iframe src="test.htm"></iframe>
</td>
</tr>
</table>
</div>
<?php require('login.htm'); ?>
<?php
require_once('common.php');
/*$path=__FILE__;
$position = strrpos($path,'\\');
$parent=substr(__FILE__,0,$position);
 $filename = $parent.'\\test.doc';
 if(file_exists($filename)) {

  // ����һ��ָ����COM��������� 
  $word = new COM('word.application') or die("Can't start Word!"); 
  
  // ��ʾĿǰ����ʹ�õ�Word�İ汾�� 
  //echo "Loading Word, v. {$word->Version}<br>"; 
  // �����Ŀɼ�������Ϊ0���٣������Ҫʹ������ǰ�˴򿪣�ʹ��1���棩 
  // to open the application in the forefront, use 1 (true) 
  //$word->Visible = 1; 
  //��?һ���ĵ� 
  $word->Documents->OPen($filename); 
  //��ȡ�ĵ����� 
  $test= $word->ActiveDocument->content->Text; 
  //���ĵ�����Ҫ���ı�������һ�� 
  //$test=str_replace('<{����}>','���Ǳ���',$test); 
  
  echo $test;
  $word->Documents->Add(); 
  // �����ĵ���������� 
  $word->Selection->TypeText($test); 
  //���ĵ�������Ŀ¼�� 
  $htmpath=$parent.'\\test.htm';
  $word->Documents[1]->SaveAs('test.htm'); 
  // �ر���COM���֮������� 
  $word->Quit(); 
  
 } else {
  echo "file is not exists";
 }
*/
 require('test.htm');
echo getOnlineIp();
?>
<textarea>
</textarea>
<?php require('.\upload\2011-04-19\test20110419112418.htm'); ?>
</body>
</html>