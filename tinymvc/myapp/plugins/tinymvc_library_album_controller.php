<?php
/**
 * default.php
 *
 * default application controller
 */

class TinyMVC_Library_album_controller extends TinyMVC_Controller
{

    var $webroot;

    function __construct()
    {
        parent::__construct();
        $this->webroot = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $this->view->assign('webroot', $this->webroot);
    }

}
