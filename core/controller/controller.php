<?php
    
/**
 * Controller
 * 
 * Handeling all the controllers and importing them.
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.controller
 * @since         hmvc (tm) v. 0.1.0.0
 * @version       hmvc (tm) v. 0.8.4.1
 * 
 */

class Controller
{
    protected 
		$_controller,
		$_model,
		$_action,
		$_view;
	
	public function __construct($controller, $action = null)
	{
        global $view;
        $this->_view = $view;

        self::importOne($controller, $action);
	}
    
    public function importOne($controller = null, $action = null, $invoke = null)
    {
        //setting the controller automatically if it was not sent by the caller
        if ( !$controller ) {
            $controller = Inflector::escape(get_class($this));
        }
        $model = Inflector::makeModelName($controller);
        
        $this->_controller = $controller;
        $this->_action     = $action;
        $this->_model      = $model;

        $this->$model      = new $model;

        //if there is an action put the controller and the action to the template list
        if ( $action ) {
            $this->_view->addToTemplates($controller, $action);
        }
        
        //invoke the method if it's required
        if ( $invoke ) {
            $controllerName = Inflector::makeControllerName($controller);
            if ( (int)method_exists($controllerName, $action) ) {
               $dispatcher = new $controllerName($controller,$action);
               call_user_func(array($dispatcher,$action));            
            }
        }
    }
    
    public function importFull($controller = null, $action)
    {
        //setting the controller automatically if it was not sent by the caller
        if ( !$controller ) {
            $controller = Inflector::escape(get_class($this));
        }
        
        $controllerName = Inflector::makeControllerName($controller);
        
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
        global $parameters;
        $dispatcher = new $controllerName($controller,$action);
    	call_user_func_array(array($dispatcher,$action),$parameters);
        $this->_view->addToTemplates($controller, $action);
        
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
    }
	
	public function set($model, $name, $value)
	{
        if ( $model ) {
            $model = Inflector::makeModelName(get_class($this));
            $this->_view->set($model, $name, $value);
        } else {
            $this->_view->set(0, $name, $value);
        }
	}
	
}