<?php

/**
 *
 * Handles loading of core files needed on every request and preparing the 
 * variables need to use globally.
 *
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core
 * @since         hmvc (tm) v. 0.2.0.0
 * @version       hmvc (tm) v. 0.5.6.1
 * 
 */
 

$startTime = microtime(true);
$numberOfQueries = 0;
$mainController = '';
$view = 0;
$numOfClasses = 0; //put it out after tesd mode
$classes = ''; //put it out after tesd mode

define(ROOT, dirname(dirname(__FILE__)));

session_start();

include_once ROOT . '/config/config.php';
include_once ROOT . '/core/config.php';
include_once ROOT . '/core/shared.php';
include_once ROOT . '/core/core.php';
