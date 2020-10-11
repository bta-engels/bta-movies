<?php
session_start();

// initialisiere variablen
$id         = null;
// name einer controller funktion
$action     = null;
// identifikator eines controllers
$controller = null;

//die('<pre>'. print_r($_GET, true).'</pre>');

// ein controller wurde als GET parameter gesetzt
if(isset($_GET['controller'])) {
    // entscheide, was hier per controller geschehen soll
    switch($_GET['controller']) {
        case 'authors':
            require_once 'Controller/AuthorController.php';
            $controller = new AuthorController;
            break;
        case 'movies':
            require_once 'Controller/MovieController.php';
            $controller = new MovieController; 
            break;
        case 'user':
            require_once 'Controller/UserController.php';
            $controller = new UserController; 
            break;
        case 'user':
            require_once 'Controller/UserController.php';
            $controller = new UserController;
            break;
        case 'api':
            require_once 'Controller/Api/ApiAuthorController.php';
            $controller = new ApiAuthorController;
            break;
    }

    // ein aktion wurde als GET parameter gesetzt
    if( $controller && isset($_GET['action'])) {
        // name einer controller funktion
        $action = $_GET['action'];

        if( method_exists($controller, $action) ) {
            // zusätzlich wurde auch ein GET parameter 'id' gesetzt
            if (isset($_GET['id']) && (int) $_GET['id'] > 0 ) {
                // führe eine eine controller funktion mit $id parameter aus
                // z:B $controller->show(3);
                $controller->$action( (int) $_GET['id']);
            } else {
                // führe eine eine controller funktion ohne parameter aus
                $controller->$action();
            }
        }
    }
} else {
    // oder mach sonstwas
    // @todo: gebe hier die start page als home-page aus
    require_once 'Views/home.php';
}
?>
