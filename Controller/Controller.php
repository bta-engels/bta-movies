<?php

class Controller {

    protected $model;
    protected $listTitle = 'Allgemeiner Titel';
    protected $showTitle = 'Allgemeiner Show Titel';
    protected $editTitle = 'Edit';
    protected $redirectToList;
    private $viewKey;

    public function __construct()
    {
        $this->viewKey = strtolower(get_class($this->model));
    }

    public function index()
    {
        $title  = $this->listTitle;
        $list   = $this->model->all();
        
        if(isset($_SESSION['auth'])) {
            require_once 'Views/' . $this->viewKey . '/admin/index.php';
        } else {
            require_once 'Views/' . $this->viewKey . '/index.php';
        }
    }

    public function show($id)
    {
        $title  = $this->showTitle;
        $item = $this->model->find($id, true);
        require_once 'Views/' . $this->viewKey . '/show.php';
    }

    public function edit($id = null)
    {
        $title = $this->editTitle;
        $data  = null;
        if( $id > 0 ) {
            // existierender datensatz
            $data = $this->model->find($id);
        }
        require_once 'Views/Forms/'.$this->viewKey.'.php';
    }

    public function save($params, $id = null) {
        if( $id > 0 ) {
            // füge den params die id als array element hinzu
            $params += ['id' => $id];
            $this->model->update($params, $id);
        } else {
            // datensatz muss neu angelegt werden
            $id = $this->model->insert($params);
        }

        // todo: fehlerbehandlung
        // redirect zur listen ansicht
        header('location: ' . $this->redirectToList);
    }

    public function delete($id) {
        $table = $this->model->delete($id);
        // redirect zur listen ansicht
        header('location: ' . $this->redirectToList);
    }
}
?>
