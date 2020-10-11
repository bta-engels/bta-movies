<?php

require_once 'Controller.php';
require_once 'Models/Movie.php';
require_once 'Models/Author.php';
require_once 'Controller.php';

class MovieController extends Controller {

    protected $listTitle = 'Movies';
    protected $showTitle = 'Movie';
    protected $uploadPath = __DIR__ . '/../uploads/';
    protected $redirectToList = '/movies';
    protected $authors;

    public function __construct() {
        $this->model = new Movie;

        $author = new Author;
        $this->authors = $author->all();
        parent::__construct();
    }

    public function index()
    {
        $selectedAuthor = null;

        if(isset($_POST['author_id']) && $_POST['author_id'] > 0) {
            $selectedAuthor = $_POST['author_id'];
            $params = ['author_id' => $selectedAuthor];
            $list = $this->model->where($params);
        } else {
            $list = $this->model->all();
        }

        $authors    = $this->authors;
        $title      = 'Movies';

        if (isset($_SESSION['auth'])) {
            require_once 'Views/movie/admin/index.php';
        } else {
            require_once 'Views/movie/index.php';
        }
    }

    public function edit($id = null)
    {

        $authors = $this->authors;
        $title = $this->editTitle;
        $data  = null;
        if( $id > 0 ) {
            // existierender datensatz
            $data = $this->model->find($id);
        }
        require_once 'Views/Forms/movie.php';
    }

    public function store($id = null)
    {
        $title  = $_POST['title'];
        $price  = $_POST['price'];
        $author_id = $_POST['author_id'];

        if( isset($_FILES['image']) && $_FILES['image']['error'] == 0 ) {
            $image          = $_FILES['image']['name'];
            $source         = $_FILES['image']['tmp_name'];
            $destination    = $this->uploadPath . $image;

            if(move_uploaded_file($source, $destination)) {
                @chmod($destination, 0666);
            }
        }
        else {
            $image = null;
        }

        // wir speichern unsere formular daten in variablen
        // todo: server-seitige validierung der form daten
        $params = [
            'author_id' => $author_id,
            'title'     => $title,
            'price'     => $price,
        ];
        if($image) {
            $params += ['image' => $image];
        }
        parent::save($params, $id);
    }

    public function delete($id)
    {
        $movie = $this->model->find($id);
        if(parent::delete($id) && $movie && '' !== $movie['image']) {
            @unlink($this->uploadPath . $movie['image']);
        }
    }
}
?>
