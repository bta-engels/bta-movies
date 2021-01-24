<?php

require_once 'Controller.php';
require_once 'Models/Movie.php';
require_once 'Models/Author.php';
require_once 'Controller.php';

/**
 * Class MovieController
 */
class MovieController extends Controller {

    /**
     * @var string
     */
    protected $listTitle = 'Movies';
    /**
     * @var string
     */
    protected $showTitle = 'Movie';
    /**
     * @var string
     */
    protected $uploadPath = __DIR__ . '/../uploads/';
    /**
     * @var string
     */
    protected $redirectToList = '/movies';
    /**
     * @var array
     */
    protected $authors;

    /**
     * MovieController constructor.
     */
    public function __construct() {
        $this->uploadPath = realpath($this->uploadPath);
        $this->model = new Movie;

        $author = new Author;
        $this->authors = $author->all();
        parent::__construct();
    }

    /**
     * get all movies
     */
    public function index() : void
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

    /**
     * @param int|null $id
     */
    public function edit(int $id = null) : void
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

    /**
     * @param int|null $id
     */
    public function store(int $id = null) : void
    {
        $title  = $_POST['title'];
        $price  = $_POST['price'];
        $author_id = $_POST['author_id'];
        // für mac und linux: upload-path muss beschreibbar sein
        if(!is_writable($this->uploadPath)) {
            die("Error: $this->uploadPath ist nicht beschreibbar!");
        }

        if( isset($_FILES['image']) && $_FILES['image']['error'] == 0 ) {
            $image          = $_FILES['image']['name'];
            $source         = $_FILES['image']['tmp_name'];
            $destination    = "$this->uploadPath/$image";

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

    /**
     * @param int $id
     */
    public function delete(int $id) : void
    {
        $movie = $this->model->find($id);
        if(parent::delete($id) && $movie && '' !== $movie['image']) {
            @unlink($this->uploadPath . $movie['image']);
        }
    }
}
?>
