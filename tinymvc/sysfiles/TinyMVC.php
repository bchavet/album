<?php

/**
 * Name:       TinyMVC
 * About:      An MVC application framework for PHP
 * Copyright:  (C) 2007-2009 Monte Ohrt, All rights reserved.
 * Author:     Monte Ohrt, monte [at] ohrt [dot] com
 * License:    LGPL, see included license file
 */

if (!defined('TMVC_VERSION')) {
    define('TMVC_VERSION', '1.2-dev');
}

/* directory separator alias */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/* define myapp directory */
if (!defined('TMVC_MYAPPDIR')) {
    define('TMVC_MYAPPDIR', TMVC_BASEDIR . 'myapp' . DS);
}

/* set include_path for spl_autoload */
set_include_path(get_include_path() .
        PATH_SEPARATOR . TMVC_BASEDIR . 'sysfiles' . DS . 'plugins' . DS .
        PATH_SEPARATOR . TMVC_BASEDIR . 'myfiles' . DS . 'plugins' . DS .
        PATH_SEPARATOR . TMVC_MYAPPDIR . 'plugins' . DS .
        PATH_SEPARATOR . TMVC_MYAPPDIR . 'models' . DS
        );

/* set .php first for speed */
spl_autoload_extensions('.php,.inc');

$spl_funcs = spl_autoload_functions();
if ($spl_funcs === false) {
    spl_autoload_register();
} elseif (!in_array('spl_autoload', $spl_funcs)) {
    spl_autoload_register('spl_autoload');
}

/**
 * tmvc
 *
 * main object class
 *
 * @package		TinyMVC
 * @author		Monte Ohrt
 */

class tmvc
{
    /* config file values */
    var $config = null;
    /* controller object */
    var $controller = null;
    /* controller method name */
    var $action = null;
    /* server path_info */
    var $path_info = null;
    /* array of url path_info segments */
    var $url_segments = null;

    /**
     * class constructor
     *
     * @access	public
     */
    public function __construct($id='default')
    {
        /* set instance */
        self::instance($this, $id);
    }

    /**
     * main method of execution
     *
     * @access	public
     */
    public function main()
    {
        /* set initial timer */
        self::timer('tmvc_app_start');

        /* set path_info */
        $this->path_info = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';

        /* internal error handling */
        $this->setupErrorHandling();

        /* include application config */
        include(TMVC_MYAPPDIR . 'configs' . DS . 'application.php');
        $this->config = $config;

        /* url remapping/routing */
        $this->setupRouting();
        /* split path_info into array */
        $this->setupSegments();
        /* create controller object */
        $this->setupController();
        /* get controller method */
        $this->setupAction();
        /* run library/script autoloaders */
        $this->setupAutoloaders();

        /* capture output if timing */
        if ($this->config['timer']) {
            ob_start();
        }

        /* execute controller action */
        $this->controller->{$this->action}();

        if($this->config['timer']) {
            /* insert timing info */
            $output = ob_get_contents();
            ob_end_clean();
            self::timer('tmvc_app_end');
            echo str_replace('{TMVC_TIMER}', sprintf('%0.5f', self::timer('tmvc_app_start', 'tmvc_app_end')), $output);
        }

    }

    /**
     * setup error handling for tmvc
     *
     * @access	public
     */
    public function setupErrorHandling()
    {
        if (defined('TMVC_ERROR_HANDLING') && TMVC_ERROR_HANDLING==1) {
            // catch all uncaught exceptions
            set_exception_handler(array('TinyMVC_ExceptionHandler', 'handleException'));
            require_once(TMVC_BASEDIR . 'sysfiles' . DS . 'plugins' . DS . 'tinymvc_errorhandler.php');
            set_error_handler('TinyMVC_ErrorHandler');
        }
    }

    /**
     * setup url routing for tmvc
     *
     * @access	public
     */
    public function setupRouting()
    {
        if (!empty($this->config['routing']['search'])&&!empty($this->config['routing']['replace'])) {
            $this->path_info = preg_replace(
                    $this->config['routing']['search'],
                    $this->config['routing']['replace'],
                    $this->path_info);
        }
    }

    /**
     * setup url segments array
     *
     * @access	public
     */
    public function setupSegments()
    {
        $this->url_segments = !empty($this->path_info) ? array_filter(explode('/', $this->path_info)) : null;
    }

    /**
     * setup controller
     *
     * @access	public
     */
    public function setupController()
    {
        /* get controller/method */
        if (!empty($this->config['root_controller'])) {
            $controller_name = $this->config['root_controller'];
            $controller_file = TMVC_MYAPPDIR . DS . 'controllers' . DS . "{$controller_name}.php";
        } else {
            $controller_name = !empty($this->url_segments[1]) ? preg_replace('!\W!', '', $this->url_segments[1]) : $this->config['default_controller'];
            $controller_file = TMVC_MYAPPDIR . DS . 'controllers' . DS . "{$controller_name}.php";
            /* if no controller, use default */
            if (!file_exists($controller_file)) {
                $controller_name = $this->config['default_controller'];
            }
        }

        try {
            include($controller_file);
        } catch (Exception $e) {
            include(TMVC_MYAPPDIR . DS . 'controllers' . DS . '404.php');
            $controller_name = 'HTTP_404';
        }

        /* see if controller class exists */
        $controller_class = $controller_name.'_Controller';

        /* instantiate the controller */
        $this->controller = new $controller_class(true);

    }

    /**
     * setup controller method (action) to execute
     *
     * @access	public
     */
    public function setupAction()
    {
        if (!empty($this->config['root_action'])) {
            /* user override if set */
            $this->action = $this->config['root_action'];
        } else {
            /* get from url if present, else use default */
            $this->action = !empty($this->url_segments[2]) ? $this->url_segments[2] :
                (!empty($this->config['default_action']) ? $this->config['default_action'] : 'index');
            /* cannot call method names starting with underscore */
            if (substr($this->action,0,1)=='_') {
                throw new Exception("Action name not allowed '{$this->action}'");
            }
        }
    }

    /**
     * autoload any libs/scripts
     *
     * @access	public
     */
    public function setupAutoloaders()
    {
        include(TMVC_MYAPPDIR . 'configs' . DS . 'autoload.php');
        if (!empty($config['libraries'])) {
            foreach ($config['libraries'] as $library) {
                if (is_array($library)) {
                    $this->controller->load->library($library[0], $library[1]);
                } else {
                    $this->controller->load->library($library);
                }
            }
        }
        if (!empty($config['scripts'])) {
            foreach ($config['scripts'] as $script) {
                $this->controller->load->script($script);
            }
        }
    }

    /**
     * instance
     *
     * get/set the tmvc object instance(s)
     *
     * @access	public
     * @param   object $new_instance reference to new object instance
     * @param   string $id object instance id
     * @return  object $instance reference to object instance
     */
    public static function &instance($new_instance = null, $id = 'default')
    {
        static $instance = array();
        if (isset($new_instance) && is_object($new_instance)) {
            $instance[$id] = $new_instance;
        }
        return $instance[$id];
    }

    /**
     * timer
     *
     * get/set timer values
     *
     * @access  public
     * @param   string $id the timer id to set (or compare with $id2)
     * @param   string $id2 the timer id to compare with $id
     * @return  float  difference of two times
     */
    public static function timer($id = null, $id2 = null)
    {
        static $times = array();
        if ($id !== null && $id2 !== null) {
            return (isset($times[$id]) && isset($times[$id2])) ? ($times[$id2] - $times[$id]) : false;
        } elseif ($id !== null) {
            return $times[$id] = microtime();
        }
        return false;
    }
}
