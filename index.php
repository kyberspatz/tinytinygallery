<?php
$gallery_name = "My Gallery";
$icon = "📸";
$pics = "pics/";
$big = "big/";
$thumb = "thumb/";
$text['comingsoon'] = $gallery_name." will be opened, soon.";
$text['buttonback'] = "back";
?><!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $gallery_name;?></title>
<meta name="robots" content="noindex, nofollow, noarchive, nosnippet, max-image-preview:none, notranslate" />
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22><?php echo $icon;?></text></svg>">
<meta name="description" content="<?php echo $gallery_name;?>">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="styles.css">
<body>

<?php
if(!is_dir($pics.$thumb)){echo '<div class="w3-container"><div class="w3-container w3-display-middle">'.$text['comingsoon'].'</div></div>';exit;}
$thumbcrawl = array_slice(scandir($pics.$thumb),2);
if(empty($thumbcrawl)){echo '<div class="w3-container"><div class="w3-container w3-display-middle">'.$text['comingsoon'].'</div></div>';exit;}

for($a=0;$a<count($thumbcrawl);$a++)
{
	$thumbcrawl[$a] = filemtime($pics.$thumb.$thumbcrawl[$a]).'|'.$thumbcrawl[$a];
}

natsort($thumbcrawl);
$thumbcrawl = array_values($thumbcrawl);

for($a=0;$a<count($thumbcrawl);$a++)
{
	$thumbcrawl[$a] = explode("|",$thumbcrawl[$a])[1];
}

$thumbcrawl = array_reverse($thumbcrawl);
$thumbcrawl = array_values($thumbcrawl);

if(!isset($_GET['image']))
{?>
<div class="w3-container" style="text-align:center;">
<h1><?php echo $gallery_name;?></h1>
<div class="w3-container" id="short">
<?php	
		for($a=0;$a<count($thumbcrawl);$a++)
		{
			echo '<a href="?image='.$thumbcrawl[$a].'"><div class="container"><img loading="lazy" class="img" src="'.$pics.$thumb.$thumbcrawl[$a].'"></div></a>';
		}
} else 
{
?>
<div class="w3-container" style="text-align:center;" style="width:100vw;">
<a href="?"><p class="w3-display-bottomleft" id="home">< <?php echo $text['buttonback'];?></p></a>
<h1><?php echo $gallery_name;?></h1>
<?php
	$max = count($thumbcrawl);
	$image = trim(strip_tags($_GET['image']));
	$imagenr = array_search($image,$thumbcrawl);
	
	if(in_array($image,$thumbcrawl))
	{
		
		 $size = getimagesize($pics.$thumb.$image);
		 $orientation = "portrait";
		if($size[0]>$size[1]){$orientation = "landscape"; }
		
		if($orientation == 'portrait'){
		echo ' <div class="w3-display-middle"><img src="'.$pics.$big.$image.'" class="imgportrait"><p>image '.($imagenr+1).' / '.($max).'</p></div>';	
		} else 
		{
			echo ' <div class="w3-display-middle"><img src="'.$pics.$big.$image.'" class="imglandscape"><p>image '.($imagenr+1).' / '.($max).'</p></div>';
		}
		
		if($imagenr>0){echo '<a href="?image='.$thumbcrawl[$imagenr-1].'"><div id="back" class="w3-display-topleft w3-half"></div></a>';}
		if($imagenr<$max-1){echo '<a href="?image='.$thumbcrawl[$imagenr+1].'"><div id="forward" class="w3-display-topright w3-half"></div></a></p>';}
	} 
	else { header("Location: ?");exit;	}
}
?>
</div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>