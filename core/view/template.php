<?php

/**
 * Rendering together all the view files
 *  
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.view.template
 * @since         hmvc (tm) v. 0.5.6.0
 * @version       hmvc (tm) v. 0.8.4.1
 * 
 */
 
class Template extends View
{
    
    public function __construct(){}
    
    public function render($variables, $templates)
    {
        //helpers
        $html = new HTML;
        $form = new Form;
        
        //opening the varibales
        extract($variables);
        
        //rendering the header
        global $mainController;
        $mainController = lowCase($mainController);

        //if there is a special header for the class
        if (  file_exists(APP_VIEWS_LIB . $mainController . '/header.php') ) {
            include_once(APP_VIEWS_LIB . $mainController . '/header.php');
        } else {
            include_once(APP_VIEWS_LIB . 'header.php');
        }
        
        //rendering all the templates
        foreach($templates as $arrays){
            foreach($arrays as $controller => $action){
                $controller = lowCase($controller);
                $action     = lowCase($action);
                if (  file_exists(APP_VIEWS_LIB . $controller . DS . $action . '.php') ) {
                    include_once(APP_VIEWS_LIB . $controller . DS . $action . '.php');
                }
            }
        }
        
        //rendering the footer
        include_once(APP_VIEWS_LIB . 'footer.php');
    }
}