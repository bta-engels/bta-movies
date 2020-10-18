<?php

require_once 'Models/Author.php';

/**
 * Class ApiAuthorController
 */
class ApiAuthorController {

    /**
     * @var Author
     */
    protected $model;

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
        $data = $this->model->all();
        die($this->_response($data));
    }

    /**
     * Get author by id
     * @param int $id
     */
    public function author(int $id) : void
    {
        $data = $this->model->find($id, true);
        die($this->_response($data));
    }

    /**
     * prepare JSON response
     * @param array $data
     * @return string
     */
    private function _response(array $data ) : string {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $result = [
            'error' => 'Sorry, Error',
            'data'  => null,
        ];

        if ($data) {
            $result = [
                'error' => null,
                'data'  => $data,
            ];
        }
        return json_encode($result);
    }
}
?>
