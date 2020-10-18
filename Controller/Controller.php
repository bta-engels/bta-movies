<?php

/**
 * Class Controller
 */
class Controller {

    /**
     * @var
     */
    protected $model;
    /**
     * @var string
     */
    protected $listTitle = 'Allgemeiner Titel';
    /**
     * @var string
     */
    protected $showTitle = 'Allgemeiner Show Titel';
    /**
     * @var string
     */
    protected $editTitle = 'Edit';
    /**
     * @var
     */
    protected $redirectToList;
    /**
     * @var string
     */
    private $viewKey;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->viewKey = strtolower(get_class($this->model));
    }

    /**
     *
     */
    public function index() : void
    {
        $title  = $this->listTitle;
        $list   = $this->model->all();

        if(isset($_SESSION['auth'])) {
            require_once 'Views/' . $this->viewKey . '/admin/index.php';
        } else {
            require_once 'Views/' . $this->viewKey . '/index.php';
        }
    }

    /**
     * @param int $id
     */
    public function show(int $id) : void
    {
        $title  = $this->showTitle;
        $item = $this->model->find($id, true);
        require_once 'Views/' . $this->viewKey . '/show.php';
    }

    /**
     * @param int|null $id
     */
    public function edit(int $id = null) : void
    {
        $title = $this->editTitle;
        $data  = null;
        if( $id > 0 ) {
            // existierender datensatz
            $data = $this->model->find($id);
        }
        require_once 'Views/Forms/'.$this->viewKey.'.php';
    }

    /**
     * @param array $params
     * @param int|null $id
     */
    public function save(array $params, int $id = null) : void {
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

    /**
     * @param int $id
     */
    public function delete(int $id) : void {
        $table = $this->model->delete($id);
        // redirect zur listen ansicht
        header('location: ' . $this->redirectToList);
    }
}
?>
