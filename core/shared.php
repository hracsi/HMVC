<?php

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

/**
 * Function that transoforming a text that you can put to an url
 * 
 * @example $text = 'helló világ oldal' -> $text = 'hello_vilag_oldal'
 * @param string: that should be transformed
 * @return string: that is transformed
 */

function generatePrettyUrl($text){ 
     $text = mb_strtolower($text, 'UTF-8'); 
     $text = str_replace('ő', 'o', $text); 
     $text = str_replace('ű', 'u', $text); 
     $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8'); 
     $text = strtr($text, utf8_decode('éáúíöüóõû'), 'eauiouoou'); 
     $text = preg_replace('/#/', 'sharp', $text); 
     $text = preg_replace('/%/', ' szazalek', $text); 
     $text = preg_replace('/\=/', 'egyenlo', $text); 
     $text = preg_replace('/\si\.?\s*$/', ' 1', $text); 
     $text = preg_replace('/\sii\.?\s*$/', ' 2', $text); 
     $text = preg_replace('/\siii\.?\s*$/', ' 3', $text); 
     $text = preg_replace('/(?![a-z0-9\s])./', '', $text); 
     $text = preg_replace('/\s\s+/', ' ', $text); 
     $text = preg_replace('/^\s|\s$/', '', $text); 
     $text = preg_replace('/\s/', '-', $text); 
      
     return $text; 
}

