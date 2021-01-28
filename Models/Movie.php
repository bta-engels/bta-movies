<?php

require_once 'Model.php';

/**
 * Class Movie
 */
class Movie extends Model {

    /**
     * @var string
     */
    protected $table = 'movies';

    /**
     * @param int $id
     * @param bool $withAuthor
     * @return array|bool
     */
    public function find($id, bool $withAuthor = true)
    {
        if(!$id || $id < 1) {
            throw new Exception('Ivalid ID Parameter');
        }

        $movie = parent::find($id);

        if($withAuthor) {
            $sql = "SELECT * , CONCAT(firstname,' ',lastname) name FROM authors WHERE id = :id";
            $author = $this->getOne( $sql, ['id' => $movie['author_id']]);
            $movie['author'] = $author;
        }

        return $movie;
    }
}
?>
