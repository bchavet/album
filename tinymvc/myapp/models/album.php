<?php

class Album extends TinyMVC_Model
{
    function list_albums()
    {
        $tmvc = tmvc::instance();

        if (!is_null($tmvc->url_segments)) {
            $dir = $tmvc->config['image_dir'] . DS . implode(DS, $tmvc->url_segments);
        } else {
            $dir = $tmvc->config['image_dir'];
        }

        $albums = scandir($dir);
        foreach ($albums as $key => $val) {
            if (!is_dir($dir . DS . $val) || $val == '.' || $val == '..') {
                unset($albums[$key]);
            }
        }

        return $albums;
    }

    function list_images()
    {
        $tmvc = tmvc::instance();

        if (!is_null($tmvc->url_segments)) {
            $dir = $tmvc->config['image_dir'] . DS . implode(DS, $tmvc->url_segments);
        } else {
            $dir = $tmvc->config['image_dir'];
        }

        $images = scandir($dir);
        foreach ($images as $key => $val) {
            if (is_dir($dir . DS . $val)) {
                unset($images[$key]);
            }
        }

        return $images;
    }
}
