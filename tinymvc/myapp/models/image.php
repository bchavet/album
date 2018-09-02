<?php

class Image extends TinyMVC_Model
{
    function get_data($filename)
    {
        $image = new Imagick($filename);
        return $image;
    }
}
