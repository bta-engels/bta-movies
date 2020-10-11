<?php

require_once 'Model.php';

class Movie extends Model {

    protected $table = 'movies';

    public function find($id, $withAuthor = true)
    {
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
