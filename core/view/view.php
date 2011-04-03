<?php

/**
 * Calling the classes and the methods
 *  
 * callHooker()
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.view
 * @since         hmvc (tm) v. 0.2.0.0
 * @version       hmvc (tm) v. 0.6.5.6
 * 
 */

class View
{
	protected 
        $templates  = array(),
		$variables  = array();
        
	private
        $count = 1;
    
    public function addToTemplates($controller, $action)
    {
        //checking whether the template was in the array or not
        $canPutIt = true;
        foreach($this->templates as $arrays){
            foreach($arrays as $cont => $act){
                if ( $cont == $controller and $act == $action) {
                    $canPutIt = false;
                } 
            }
        }
        
        //putting the template if it's unique
        if ( $canPutIt ) {
            $this->templates[$this->count] = array($controller => $action);
            $this->count++;            
        }        
    }
    
    //setting the variable into the array
	public function set($model, $name, $value)
	{
		if ( $model ) {
		  $this->variables[$model][$name] = $value;  
		} else {
		  $this->variables[$name] = $value;
		}
        
	}
    
	public function callingTemplate()
	{
        $template = new Template;
        $template->render($this->variables, $this->templates);
	}
    
    public function __destruct() 
    {
        unset($this->variables);
        unset($this->templates);
    }
}