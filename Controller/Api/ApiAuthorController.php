<?php

require_once 'Models/Author.php';

class ApiAuthorController {

    protected $mode;

    public function __construct()
    {
        $this->model = new Author;
    }
    public function authors() {
        $data = $this->model->all();
        die($this->_response($data)); 
    }

    public function author($id)
    {
        $data = $this->model->find($id, true);
        die($this->_response($data)); 
    }

    private function _response($data) {
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
