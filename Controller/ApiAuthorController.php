<?php
require_once 'Models/Author.php';
require_once 'Controller/Controller.php';

/**
 * Class ApiAuthorController
 */
class ApiAuthorController extends Controller {

    /**
     * ApiAuthorController constructor.
     */
    public function __construct()
    {
        $this->model = new Author;
    }

    /**
     * Get all authors
     */
    public function authors() : void {
        try {
            $data = $this->model->all();
            die($this->_response($data));
        } catch(Exception $e) {
            $error = $e->getMessage();
            die($this->_response(null, $error));
        }
    }

    /**
     * Get author by id
     * @param int $id
     */
    public function author($id = null) : void
    {
        try {
            $data = $this->model->find($id, true);
            die($this->_response($data));
        } catch(Exception $e) {
            $error = $e->getMessage();
            die($this->_response(null, $error));
        }
    }

    /**
     * prepare JSON response
     * @param array $data
     * @return string
     */
    private function _response($data, $error = null ) : string {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $result = [
            'data'  => $data,
            'error' => $error,
        ];
        return json_encode($result);
    }
}
?>
