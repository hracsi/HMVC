<?php

/**
 *
 * defining the libaries and do some configuration  
 *
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.config
 * @since         hmvc (tm) v. 0.5.6.1
 * @version       hmvc (tm) v. 0.5.5.6
 * 
 */

define('DS',DIRECTORY_SEPARATOR);

if (!defined(ROOT)) {
    define(ROOT, dirname(dirname(__FILE__)) . DS);
}

define('CONFIG_LIB',ROOT . DS . 'config' . DS);

define('CORE_LIB',ROOT . DS . 'core' . DS);

define('APPLICATION_LIB',ROOT . DS . 'app' . DS);

define('CONTROLLERS_LIB',APPLICATION_LIB . 'controllers' . DS);

define('MODELS_LIB',APPLICATION_LIB . 'models' . DS);

define('VIEWS_LIB_LIB',APPLICATION_LIB . 'views' . DS);

define('PUBLIC_LIB',ROOT . DS . 'public' . DS);

define('IMG_LIB',PUBLIC_LIB . DS . 'img' . DS);

define('CSS_LIB',PUBLIC_LIB . DS . 'css' . DS);

define('JS_LIB',PUBLIC_LIB . DS . 'js' . DS);

define('DB_STORE_LIB',ROOT . DS . 'db' . DS);

define('TMP_LIB',ROOT . DS . 'tmp' . DS);

define('CACHE_LIB',TMP_LIB . DS . 'cache' . DS);

define('LOG_LIB',TMP_LIB . DS . 'logs' . DS);

define('SESSIONS_LIB',TMP_LIB . DS . 'sessions' . DS);

session_save_path(SESSIONS_LIB);

?>