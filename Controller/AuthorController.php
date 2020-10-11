<?php

require_once 'Controller.php';
require_once 'Models/Author.php';


class AuthorController extends Controller {

    protected $listTitle = 'Autoren';
    protected $showTitle = 'Autor';
    protected $editTitle = 'Edit Autor';
    protected $redirectToList = '/authors';


    public function __construct() {
        $this->model = new Author;
        parent::__construct();
    }

    public function store($id = null)
    {
        // wir speichern unsere formular daten in variablen
        $firstname  = $_POST['firstname'];
        $lastname   = $_POST['lastname'];
        // todo: server-seitige validierung der form daten
        $params = [
            'firstname' => $firstname,
            'lastname'  => $lastname
        ];
        $this->save($params, $id);
    }
}
?>
