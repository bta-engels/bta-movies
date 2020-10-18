<?php

require_once 'Models/User.php';

/**
 * Class UserController
 */
class UserController {

    /**
     * @var User
     */
    private $model;
    /**
     * @var string
     */
    private $redirectTo = '/';

    /**
     * UserController constructor.
     */
    public function __construct() {
        $this->model = new User;
    }

    /**
     * get login form
     */
    public function login() : void
    {
        $title      = 'Login';
        require_once 'Views/Forms/login.php';
    }

    /**
     * check login data and redirect user
     */
    public function check() : void
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

    /**
     * logout a user
     */
    public function logout() : void
    {
        unset($_SESSION['auth']);
        session_destroy();
        header('location: '.$this->redirectTo);
    }
}

?>
