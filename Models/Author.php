<?php

require_once 'Model.php';

/**
 * Class Author
 */
class Author extends Model {

    protected $class = __CLASS__;

    /**
     * @var string
     */
    protected $table = 'authors';
    public $movies;

    /**
     * @param int $id
     * @param bool $withMovies
     * @return array|bool
     */
    public function find($id, bool $withMovies = false)
    {
        if(!$id || $id < 1) {
            throw new Exception('Ivalid ID Parameter');
        }
        $author = parent::find($id);

        if($withMovies) {
            $sql = "SELECT * FROM movies WHERE author_id = :id";
            $this->movies = $this->getAll($sql, ['id' => $id]);
        }

        return $author;
    }
}
?>
