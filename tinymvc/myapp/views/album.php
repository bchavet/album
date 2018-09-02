<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/strict.dtd">
<html>
<head>
<title>Photo Album</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?php echo $webroot; ?>/css" rel="stylesheet" type="text/css" />
</head>

<body>

<h1>Album</h1>

<div id="albums">
<?php
foreach ($albums as $album) {
    echo '<span class="album"><a href="' . $webroot . '/' . $path . '/' . $album . '">' . $album . '</a></span>';
}
?>
</div>

<div id="thumbs">
<?php
foreach ($images as $image) {
    echo '<span class="thumb"><a href="' . $webroot . '/' . $path . '/' . $image . '"><img src="' . $webroot . '/' . $path . '/' . str_replace(substr($image, -4), '___thumb' . substr($image, -4), $image) . '" /></a></span>' . "\n";
}
?>
</div>

</body>
</html>
