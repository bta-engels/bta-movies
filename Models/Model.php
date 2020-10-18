<?php
require_once 'inc/MyDB.php';

/**
 * Class Model
 */
class Model extends MyDB {

    /**
     * @var string
     */
    protected $table;

    /**
     * @return string
     */
    public function getTable() : string
    {
        return $this->table;
    }

    /**
     * get all data
     * @return array
     */
    public function all() : array
    {
        $sql = 'SELECT * FROM ' . $this->table;
        return $this->getAll($sql);
    }

    /**
     * get one dataset by id
     * @param int $id
     * @return array
     */
    public function find(int $id) : array
    {
        $sql = 'SELECT * FROM '. $this->table.' WHERE id = :id';
        $result = $this->getOne($sql, ['id' => $id]);

        return $result;
    }

    /**
     * get data by condition as array
     * @param array $params
     * @return array
     */
    public function where(array $params) : array
    {
        $conditions = [];
        foreach(array_keys($params) as $item) {
            $conditions[] = "$item = :$item";
        }
        $strConditions = implode(' AND ', $conditions);
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $strConditions;

        return $this->getAll($sql, $params);
    }

    /**
     * update data
     * @param array $params
     * @param int $id
     * @return PDOStatement
     */
    public function update(array $params, int $id) : PDOStatement
    {
        // baue mir ein array mit spaltenname und spalten platzhalter anhand der $params
        $updateValues = [];
        // array_keys liefert alle keys eines arrays als array
        foreach (array_keys($params) as $key) {
            // z.B: 'title = :title'
            $updateValues[] = "$key = :$key";
        }
        // baue mir eine zeichenkette aus dem $updateValues array mit komma als verbindungs-zeichen
        // z.B: 'title = :title, price = :price, auhtor_id = :author_id ....'
        $strUpdateValues = implode(', ', $updateValues);
        // setze meine SQL anweisung zusammen
        $sql = "UPDATE $this->table SET $strUpdateValues WHERE id = :id";
        // füge die id als assoziatives array den $params hinzu
        $params += ['id' => $id];
        // führe über execute das SQL kommando aus anhand der parameter in $params
        $result = $this->prepareAndExecute($sql, $params);

        return $result;
    }

    /**
     * insert data
     * @param array $params
     * @return int
     */
    public function insert(array $params) : int
    {
        $columnNames    = [];
        $placeholders   = [];

        // array_keys liefert alle keys eines arrays als array
        foreach (array_keys($params) as $key) {
            // array aller Spalten Namen
            $columnNames[]  = $key;
            // array aller Spalten Placeholders
            $placeholders[] = ":$key";
        }
        $strColumnNames     = implode(',', $columnNames);
        $strPlacesholders   = implode(',', $placeholders);
        // setze meine SQL anweisung zusammen
        $sql = "INSERT INTO $this->table ($strColumnNames) VALUES ($strPlacesholders);";
        // preapare statment anhand SQL anweisung
        // führe über execute das SQL kommando aus anhand der parameter in $params
        // gebe fehlermeldungen aus, wenn was schiefgelaufen ist
        $this->prepareAndExecute($sql, $params);

        return $this->lastInsertId();
    }

    /**
     * delete dataset by id
     * @param int $id
     * @return PDOStatement
     */
    public function delete(int $id) : PDOStatement {
        $sql = 'DELETE FROM '. $this->table. ' WHERE id = ?';
        return $this->prepareAndExecute($sql, [ $id ]);
    }
}
?>
