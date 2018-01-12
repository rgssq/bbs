<?php
// Original image
$filename = $_GET['p'];
$PointX = $_GET['x'];
$PointY = $_GET['y'];
$CutWidth = $_GET['w'];
$CutHeight = $_GET['h'];
$PicWidth = $_GET['pw'];
$PicHeight = $_GET['ph'];
if($PointX < 0)
	$PointX = 0;
if($PointY < 0)
	$PointY =0;
if($CutWidth > $PicWidth)
	$CutWidth = $PicWidth;
if($CutHeight > $PicHeight)
	$CutHeight = $PicHeight;
$pos = strrpos($filename,'.');
$ext=substr($filename,$pos);
$name=substr($filename,0,$pos);

$newfile = $name.'n'.$ext;
// Get dimensions of the original image
list($current_width, $current_height) = getimagesize($filename);

// The x and y coordinates on the original image where we
// will begin cropping the image
$left = $PointX * $current_width / $PicWidth;
$top = $PointY * $current_height / $PicHeight;

// This will be the final size of the image (e.g. how many pixels
// left and down we will be going)
$crop_width = $CutWidth * $current_width / $PicWidth;
$crop_height = $CutHeight * $current_height / $PicHeight;
// Resample the image
$canvas = imagecreatetruecolor($crop_width, $crop_height);
$current_image = imagecreatefromjpeg($filename);
imagecopy($canvas, $current_image, 0, 0, $left,$top , $CutWidth * $current_width / $PicWidth , $CutHeight * $current_height / $PicHeight);
imagejpeg($canvas, $newfile, 100);
$response = $newfile;
session_start();
$save=str_replace('\\','\\\\','.\\hotNews'.substr($newfile,1));
$_SESSION['hotPic'] = $save;
echo $response;
?>