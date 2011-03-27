<?php

/**
 * Rendering together all the view files
 *  
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.view.template
 * @since         hmvc (tm) v. 0.5.6.0
 * @version       hmvc (tm) v. 0.7.5.6
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
        //if there is a special header for the class
        if (  file_exists(VIEWS_LIB_LIB . $mainController . '/header.php') ) {
            include_once(VIEWS_LIB_LIB . $mainController . '/header.php');
        } else {
            include_once(VIEWS_LIB_LIB . 'header.php');
        }
        
        //rendering all the templates
        foreach($templates as $arrays){
            foreach($arrays as $controller => $action){

                $controller = strToLower($controller);
                $action     = strToLower($action);
                //echo '<br />c: ' . $controller . ' ---- m: ' . $action;
                if (  file_exists(VIEWS_LIB_LIB . $controller . '/' . $action . '.php') ) {
                    include_once(VIEWS_LIB_LIB . $controller . '/' . $action . '.php');
                }

            }
        }
        
        //rendering the footer
        include_once(VIEWS_LIB_LIB . 'footer.php');
    }
}