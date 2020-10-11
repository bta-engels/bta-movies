<?php

require_once 'Model.php';

class Author extends Model {

    protected $table = 'authors';

    public function find($id, $withMovies = false)
    {
        $author = parent::find($id);

        if($withMovies) {
            $sql = 'SELECT * FROM movies WHERE author_id = :id';
            $movies = $this->getAll($sql, ['id' => $author['id']]);
            $author['movies'] = $movies;
        }

        return $author;
    }
}
?>
