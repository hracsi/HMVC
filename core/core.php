<?php

/**
 * Starting the MVC.
 *  
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core
 * @since         hmvc (tm) v. 0.5.6.0
 * @version       hmvc (tm) v. 0.8.4.0
 * 
 */
 
/**
 * callHooker()
 * 
 * Calling the classes and the methods.
 * 
 * @return void
 */
 
function callHooker()
{
	global $url,$default,$view,$parameters,$mainController;
    
    //celaring all variables in the $_POST and $_GET avoiding sql or html code injection
    $_POST = clearArray($_POST);
    $_GET  = clearArray($_GET);
    
    $parameters = array();
	if ( !isset($url) ) {
		$controller = $default['controller'];
		$action     = $default['action'];
	} else {
		$urlArray = explode('/',$url);
		$urlArray = clearArray($urlArray);		

		$controller = $urlArray[0];
		array_shift($urlArray);
		if (isset($urlArray[0])) {
			$action = $urlArray[0];
			array_shift($urlArray);
		} else {
			$action = 'index';
		}
		$parameters = $urlArray;
	}
	
    $controllerName = ucfirst($controller) . 'Controller';
    $mainController = $controller;

    /** If the class doesn't exist call the default controller and action **/
    if ( !class_exists($controllerName) ) {
        /** MAKE A LOG HERE **/
        $controller     = $default['controller'];
        $action         = $default['action'];
        $controllerName = ucfirst($controller) . 'Controller';
    }


    if ( !(int) method_exists($controllerName, $action) ) {
        /** MAKE A LOG HERE **/
        $controller     = ucfirst($default['controller']);
        $action         = $default['action'];
        $controllerName = $controller . 'Controller';
    }
    
    /** Calling the classes and the actions with the right parameter **/ 
    
    //the View
    $view = new View($controller,$action);

    //beforeClass
    $newAction = 'before' . $controller;
    if ( (int)method_exists($controllerName, $newAction) ) {
       $dispatcher = new $controllerName($controller,$newAction);
	   call_user_func(array($dispatcher,$newAction));            
    }
    
    //beforeAction
    $newAction = 'before' . $action;
    if ( (int)method_exists($controllerName, $newAction) ) {
       $dispatcher = new $controllerName($controller,$newAction);
	   call_user_func(array($dispatcher,$newAction));
    }
    
    //calling the Action
    $dispatcher = new $controllerName($controller,$action);
	call_user_func_array(array($dispatcher,$action),$parameters);
         
    //afterAction
    $newAction = 'after' . $action;
    if ( (int)method_exists($controllerName, $newAction) ) {
       $dispatcher = new $controllerName($controller,$newAction);
	   call_user_func(array($dispatcher,$newAction));            
    }
    //afterClass
    $newAction = 'after' . $controller;
    if ( (int)method_exists($controllerName, $newAction) ) {
       $dispatcher = new $controllerName($controller,$newAction);
	   call_user_func(array($dispatcher,$newAction));            
    }
    
    $view->callingTemplate();
    return 1;
}

/**
 * __autoload()
 * 
 * @param mixed $className
 * @return
 */

function __autoload($className){
        global $numOfClasses,$classes;
        $numOfClasses++;
        $classes = $classes . ' - ' . $className;

        $className = lowCase($className);
        if ( file_exists(CORE_LIB . $className . '.php') ) {
    		include_once(CORE_LIB . $className . '.php');
            return true;
    	}
    	elseif ( file_exists(CONTROLLERS_LIB . $className . '.php') ) {
    		include_once(CONTROLLERS_LIB . $className . '.php' );
            return true;
    	}
    	elseif ( file_exists(MODELS_LIB . $className . '.php') ) {
    		include_once (MODELS_LIB . $className . '.php');
            return true;
    	}
        elseif ( file_exists(VIEWS_LIB . $className . '.php') ) {
    	   include_once (VIEWS_LIB . $className . '.php');
           return true;
    	}
        elseif ( file_exists(APP_CONTROLLERS_LIB . $className . '.php') ) {
    	   include_once(APP_CONTROLLERS_LIB . $className . '.php');
           return true;
    	}
        elseif ( file_exists(APP_MODELS_LIB . $className . '.php') ) {
    	   include_once(APP_MODELS_LIB . $className . '.php');
           return true;
    	}
        else {
    		/** MAKE A LOG HERE **/
            return false;
    	}
}

setErrorReporting();
callHooker();
