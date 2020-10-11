<?php

require_once 'Models/User.php';

class UserController {

    /**
     * @var User
     */
    private $model;
    private $redirectTo = '/';

    public function __construct() {
        $this->model = new User;
    }


    public function login()
    {
        $title      = 'Login';
        require_once 'Views/Forms/login.php';
    }

    public function check()
    {
        $user = $this->model->get($_POST['username'], $_POST['password']);
        if ($user){
            $_SESSION['auth'] = $user;
            header('location: '.$this->redirectTo);
        } else{
            header('location: /login');
        }
        if ($user) {
            // Login erfolgreich
            // wir bauen uns eine Session namens 'auth' und speichern darin $user
            $_SESSION['auth'] = $user; 
            header('location: ' . $this->redirectTo);
        } else {
            // @todo: redirect zum login form mit fehlermeldung, daß user daten nicht korrekt sind
            header('location: /login');
        }

    }

    public function logout()
    {
        unset($_SESSION['auth']);
        session_destroy();
        header('location: '.$this->redirectTo);
         
    }
}

?> 
