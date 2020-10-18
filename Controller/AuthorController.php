<?php

require_once 'Controller.php';
require_once 'Models/Author.php';


/**
 * Class AuthorController
 */
class AuthorController extends Controller {

    /**
     * @var string
     */
    protected $listTitle = 'Autoren';
    /**
     * @var string
     */
    protected $showTitle = 'Autor';
    /**
     * @var string
     */
    protected $editTitle = 'Edit Autor';
    /**
     * @var string
     */
    protected $redirectToList = '/authors';

    /**
     * AuthorController constructor.
     */
    public function __construct() {
        $this->model = new Author;
        parent::__construct();
    }

    /**
     * @param int|null $id
     */
    public function store(int $id = null) : void
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
