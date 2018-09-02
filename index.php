<?php

/* PHP error reporting level, if different from default */
error_reporting(E_ALL);

/* if the /tinymvc/ dir is not up one directory, uncomment and set here */
define('TMVC_BASEDIR', 'tinymvc/');

/* define to 0 if you want errors/exceptions handled externally */
define('TMVC_ERROR_HANDLING',1);

/* directory separator alias */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/* include main tmvc class */
require(TMVC_BASEDIR . 'sysfiles' . DS . 'TinyMVC.php');

/* instantiate */
$tmvc = new tmvc();

/* tally-ho! */
$tmvc->main();
