<?php

require_once 'Model.php';

/**
 * Class Author
 */
class Author extends Model {

    /**
     * @var string
     */
    protected $table = 'authors';

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
            $movies = $this->getAll($sql, ['id' => $author['id']]);
            $author['movies'] = $movies;
        }

        return $author;
    }
}
?>
