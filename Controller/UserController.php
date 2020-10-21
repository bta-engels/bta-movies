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
        $title  = 'Login';
        $error  = null; 
        require_once 'Views/Forms/login.php';
    }

    /**
     * check login data and redirect user
     */
    public function check() : void
    {
        // lese formular daten aus u. speichere sie in variablen 
        // entferne per trim etwaige leerzeichen vom anfang und ende der formular-daten
        $username = trim($_POST['username']);
        // verschlüssle das Klartext-Passwort als MD5-Hash
        // liegt in der DB in dieser Form verschlüsselt vor
        $password = md5(trim($_POST['password']));
        
        // benutze model User für user Abfrage as DB
        $user = $this->model->get($username, $password);
        if($user) {
            if(!isset($_SESSION['auth'])) {
                $_SESSION['auth'] = $user;
            }
            // leite um auf Startseite
            header("location: $this->redirectTo");
        } else {
            $title = 'Login';
            $error = 'Falsche Login-Daten!';
            require_once 'Views/Forms/login.php';
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
