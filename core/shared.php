<?php

/**
 *
 * A few useful functions that can be reached globaly.  
 *
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.config
 * @since         hmvc (tm) v. 0.2.1.0
 * @version       hmvc (tm) v. 0.8.4.0
 * 
 */


/**
 * Function to set the level of reporting
 * 
 * @param int level of error report
 * @return void
 */
 
function setErrorReporting($level = DEBUG_MODE)
{
	if($level == 2) {
		error_reporting(E_ALL ^ E_NOTICE);
        //error_reporting(E_ALL);
		ini_set('display_errors','On');
	} elseif($level == 1) {
		error_reporting(E_ALL ^ E_NOTICE);
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT .'/tmp/logs/errors.log');
	} else {
		error_reporting(0);
		ini_set('display_errors','Off');
		ini_set('log_errors', 'Off');
	}
}

/**
 * Escapes the strings in the array which contains html or mysql special chars
 *
 * @param array: that will be cleared 
 * @return array: a clear array
 */
 
function clearArray($array)
{
    $newArray = array();
    foreach($array as $name => $value) {
	   $newArray[$name] = mysql_escape_string(htmlspecialchars($value));
    }
    return $newArray;
}

/**
 * Convenience method for redirecting
 *
 * @param string: the url that the function will put in to the JS code
 * @return string: the generated JS code
 */

function redirect($url = null)
{
    if ( $url == null ) {
        $url = $_SERVER['HTTP_REFER'];
    }
    echo '<script type="text/javascript">top.location.href ="' . $url. '"</script>';
}

/**
 * Convenience method for strtolower().
 *
 * @param string $str String to lowercase
 * @return string Lowercased string
 */
	function lowCase($str) {
		return strtolower($str);
	}

/**
 * Convenience method for strtoupper().
 *
 * @param string $str String to uppercase
 * @return string Uppercased string
 */
	function upCase($str) {
		return strtoupper($str);
	}
