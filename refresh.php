<?php

$photopath = "/var/www/nextcloud/place/your/photo/folder/here";
$pics = "/var/www/html/yourwebsite/gallery/pics/";

$big = "big/";
$thumb = "thumb/";

if(!is_dir($pics)){mkdir($pics);}
if(!is_dir($pics.$big)){mkdir($pics.$big);}
if(!is_dir($pics.$thumb)){mkdir($pics.$thumb);}

$content = array_slice(scandir($fotopath),2);
$bigcrawl = array_slice(scandir($pics.$big),2);
$thumbcrawl = array_slice(scandir($pics.$thumb),2);

//delete
foreach($bigcrawl as $photo)
{
	if(!is_file($fotopath.$photo))
	{
		echo "!!!".$photo."<br>";
		unlink($pics.$big.$photo);
		$action=1;
	}
}

foreach($thumbcrawl as $photo)
{
	if(!is_file($fotopath.$photo))
	{
		echo "!!!".$photo."<br>";
		unlink($pics.$thumb.$photo);
		$action=1;
	}
}

//fetch
include_once("thumbnailgenerator.php");
$tg = new thumbnailGenerator;

$allowed_files = array('.jpg','.jpeg','.png','.bmp','.gif');
foreach($content as $photo)
{
	$check = substr($photo,strrpos($photo,"."));
	if(!in_array($check,$allowed_files)){GOTO NEXT;}
		
	if(!is_file($pics.$thumb.$photo))
	{
		$px = 300; // size in pixel of the thumbnail
		$width = $px;
		$height = $px;
		$size = getimagesize($fotopath.$photo);
		if($size[0]>$size[1])	{$height = $px*$size[1]/$size[0];} else {$width = $px*$size[0]/$size[1];}
		$tg->generate($fotopath.$photo, $width, $height, $pics.$thumb.$photo);
		echo "--->".$photo."<br>";
		$action=1;
	}	
	
	if(!is_file($pics.$big.$photo))
	{
		$px = 1200; // size in pixel of the copied photo
		$width = $px;
		$height = $px;
		$size = getimagesize($fotopath.$photo);
		if($size[0]>$size[1])	{$height = $px*$size[1]/$size[0];} else {$width = $px*$size[0]/$size[1];}
		$tg->generate($fotopath.$photo, $width, $height, $pics.$big.$photo);
		echo "--->".$photo."<br>";
		$action=1;
	}
	
	NEXT:
}

if(!isset($action)){echo "Folder is up-to-date.";}
?>