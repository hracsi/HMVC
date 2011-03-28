<?php

/**
 * Form
 * 
 * Helper for html operations
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.view.helpers.form
 * @since         hmvc (tm) v. 0.1.0.0
 * @version       hmvc (tm) v. 0.7.9.8 beta
 * 
 */
 
class Form extends HTML
{
    
    public $inputs = array('text', 'password', 'submit', 'button', 'reset', 'image', 'file', 'checkbox', 'radio', 'hidden');


    public function create($model = null, $options = array() )
    {
        global $url;
        
        $form = '<form ';
        //setting the id
        if ( in_array('id', $options) ) {
            $form = $form . 'id="' . $options ['id'] . '" ';
        }
        //setting type
        if ( $options['type'] == 'file' ) {
            $form = $form . 'enctype="multipart/form-data" ';
        }
        //setting the method
        if ( in_array('method', $options) ) {
            $form = $form . 'method="' . $options ['method'] . '" ';
        } else {
            $form = $form . 'method="post" ';
        }
        //setting action
        if ( in_array('url', $options) ) {
            if ( is_array($options['url'] ) ) {
                $form = $form . 'action="' . parent::url($options['url']) . '" ';
            } else {
                $form = $form . 'action="' . $options['url'] . '" ';
            }
        } else {
            $form = $form . 'action="' . $url . '" ';
        }
        $form = $form . '>';
        return $form . "\r\n";
    }
    
    
    public function end($value = null)
    {
        if ( $value ) {
            
        } else {
            $form = '</form>';
        }
        return $form . "\r\n";
    }

    public function input($options)
    {
        print_r($options);
        $input = '<input type="' . $options[1] . '" ';
        foreach($options as $property => $value){
            $input = $input . $property . '="' . $value . '" ';
        }
        $input = $input . END_TAG . '>';
        echo 'in: ' . $input;
    }
    
    public function __call( $method, $params)
    {
        if ( in_array($method, $this->inputs) ) {
            $params['type'] = $method;
            print_r($params);
            $dispatcher = new Form;
            call_user_func_array(array($dispatcher,'input'), $params);
        }
    }
}