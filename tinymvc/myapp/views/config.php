<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/strict.dtd">
<html>
<head>
  <title>Welcome to PHP Web Album</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href="<?php echo $webroot; ?>/css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Web Album Configuration</h1>

<h2>Configuration Tests</h2>

<table class="config">
    <tr>
        <td class="test">Image Directory:</td>
        <td class="<?php echo $image_dir ? 'pass' : 'fail'; ?>"><?php echo $image_dir ? $image_dir : 'Failed'; ?></td>
    </tr>
    <tr>
        <td class="test">Cache Directory:</td>
        <td class="<?php echo $cache_dir ? 'pass' : 'fail'; ?>"><?php echo $cache_dir ? $cache_dir : 'Failed'; ?></td>
    </tr>
</table>

<p>
If one or more of these tests failed, make sure that <span class="filename"><?php echo dirname($_SERVER['SCRIPT_FILENAME']) . '/config.php'; ?></span> is configured properly.
</body>
</html>
