<?php
session_start();
// schalte penible fehler ausgabe ein, zeigt auch warnungen
error_reporting(E_ALL);

require_once 'inc/Helper.php';

// initialisiere variablen
$id         = null;
// name einer controller funktion
$action     = null;
// identifikator eines controllers
$controller = null;

// wenn 'controller' als GET parameter gesetzt wurde
if( isset($_GET['controller']) ) {
    // Hier setze anhand der GET Parameter die Werte für die obigen Variablen
    // block von gleichberechtigten if statements
    switch($_GET['controller']) {
        case 'user':
            // hier login funktion des UserControllers aufrufen
            require_once 'Controller/UserController.php';
            $controller = new UserController();
            break;
        case 'authors':
            require_once 'Controller/AuthorController.php';
            $controller = new AuthorController();
            break;
        case 'movies':
            require_once 'Controller/MovieController.php';
            $controller = new MovieController();
            break;
        case 'api':
            require_once 'Controller/ApiAuthorController.php';
            $controller = new ApiAuthorController();
            break;
    }
/*
    hier $action setzen, wenn $controller nicht null ist
    UND isset($_GET['action'])
    UND eine methode $action des objekts $controller existiert (php-funktion: method_exists)
*/
    if( $controller && isset($_GET['action']) && method_exists($controller, $_GET['action']) ) {
        $action = $_GET['action'];
        /*
        UserController funktionen: login, check, logout
        AuthorController, MovieController Funktionen:
        index, show($id), edit($id = null), store($id = null), delete($id)
        Aufruf der methode $action mittels der objekt-instanz $controller
        todo: id aus $_GET abfragen ($id damit setzen), falls vorhanden.
        wenn vorhanden und grösser 0, dann als parameter der objekt methode setzen:
        $controller->$action($id);
        wenn nicht vorhanden dann: $controller->$action();
        in der variablen $action steckt der name der controller funktion, die aufgerufen werden soll
        */
        if( isset($_GET['id']) ) {
            $id = (int) $_GET['id'];
            $controller->$action($id);
        } else {
            $controller->$action();
        }
    } else {
        // ansonsten zeige die home page
        require_once 'Views/home.php';
    }

} else {
    // ansonsten zeige die home page
    require_once 'Views/home.php';
}

//Helper::dump($_GET);
?>
