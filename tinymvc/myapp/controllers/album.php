<?php
/**
 * default.php
 *
 * default application controller
 */

class Album_Controller extends TinyMVC_Library_album_controller
{

    function index()
    {
        $tmvc = tmvc::instance();

        // config sanity checks
        if (!isset($tmvc->config['image_dir']) || !isset($tmvc->config['cache_dir'])) {
            $this->view->assign('image_dir', isset($tmvc->config['image_dir']) ? $tmvc->config['image_dir'] : false);
            $this->view->assign('cache_dir', isset($tmvc->config['cache_dir']) ? $tmvc->config['cache_dir'] : false);
            $this->view->display('config');
            return;
        }

        // Action director
        switch ($tmvc->url_segments[1]) {
            case 'css':
                $this->css();
                break;
            case '404':
                $this->http_404();
                break;
            default:
                $this->album();
        }

    }

    function album()
    {
        $tmvc = tmvc::instance();

        $path = empty($tmvc->url_segments) ? '' : implode('/', $tmvc->url_segments);
        $file = $tmvc->url_segments[count($tmvc->url_segments)];
        $filetype = substr($file, strrpos($file, '.'));
        $thumbnail = strrpos($file, '___thumb' . $filetype);

        if (strcasecmp($filetype, '.jpg') == 0 || strcasecmp($filetype, '.png') == 0 || strcasecmp($filetype, '.gif') == 0) {

            if ($thumbnail !== false) {
                $this->load->model('thumb');
                $this->view->assign('data', $this->thumb->get_data($tmvc->config['image_dir'] . DS .  $path));
            } else {
                $this->load->model('image');
                $this->view->assign('data', $this->image->get_data($tmvc->config['image_dir'] . DS . $path));
            }

            $this->view->display(substr(strtolower($filetype), 1));

        } else {

            $this->load->model('album');
            $this->view->assign('albums', $this->album->list_albums());
            $this->view->assign('images', $this->album->list_images());
            $this->view->assign('path', $path);

            $this->view->display('album');

        }
    }

    function css()
    {
        $this->view->display('css');
    }

    function http_404()
    {
        $this->view->display('404');
    }
}
