<?php

class Thumb extends TinyMVC_Model
{
    function get_data($filename)
    {
        $filename = str_replace(substr($filename, -12), substr($filename, -4), $filename);
        $image = new Imagick($filename);
        $image->thumbnailImage(100,0);
        return $image;
    }
}
