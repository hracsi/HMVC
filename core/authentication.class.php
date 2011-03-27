<?php

/**
 * Maneging the administrators and users authentication
 *  
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core
 * @since         hmvc (tm) v. 0.1.0.0
 * @version       hmvc (tm) v. 0.7.5.6
 * 
 */

class Authentication 
{

    public function adminLogin($pwd = '')
    {
        if ( $_SESSION['admin']  ==  'Y' ) {
            return true;
        } elseif ( $pwd == ADMIN_PASSWORD ) {
            $_SESSION['admin'] = 'Y'; 
            return true;
        } else {
            return false;
        }
    }

    public function userLogin($condition, $model, $sessionName)
    {
        if ( $_SESSION['verify'] == 'Y' ) {
            return $_SESSION[$sessionName];
        }
        $user = $model->prepare()->where($condition)->execute()->fetchAll();
        if ( empty($user) ) {
            $_SESSION['verify'] = false;
            $_SESSION[$sessionName] = null;
            return false;
        } else {
            $_SESSION['verify'] = 'Y';
            $_SESSION[$sessionName] = $user;
            return $_SESSION[$sessionName];
        }
    }
    
    public function logout()
    {
        if ( $_SESSION['verify'] == 'Y' or $_SESSION['admin'] == 'Y'){
            $_SESSION = array();
            session_destroy();
        }
    }

}