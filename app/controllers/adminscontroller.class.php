<?php

class AdminsController extends Controller
{
    public function login()
    {
        if ( $_SESSION['admin'] != 'Y' and isset($_POST['password']) ) {
            Authentication::adminLogin($_POST['password']);
            //redirect('/');
        } else {
            $this->set(1,'form',array('action' => '/admins/login/', 'method' => 'post'));
        }
    }
    
    public function logout()
    {
        Authentication::logout();
        redirect('/');
    }
}