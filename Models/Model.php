<?php
require_once 'inc/MyDB.php';

class Model extends MyDB {

    protected $table;

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    public function all()
    {
        $sql = 'SELECT * FROM ' . $this->table;
        return $this->getAll($sql);
    }

    public function find($id)
    {
        $sql = 'SELECT * FROM '. $this->table.' WHERE id = :id';
        $result = $this->getOne($sql, ['id' => $id]);

        return $result;
    }

    public function where($params)
    {
        $conditions = [];
        foreach(array_keys($params) as $item) {
            $conditions[] = "$item = :$item";
        }
        $strConditions = implode(' AND ', $conditions);
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $strConditions;
        return $this->getAll($sql, $params);
    }

    public function update($params, $id)
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
        // preapare statment anhand SQL anweisung
        $stmt = $this->prepare($sql);
        // füge die id als assoziatives array den $params hinzu
        $params += ['id' => $id];
        // führe über execute das SQL kommando aus anhand der parameter in $params
        $result = $stmt->execute($params);
        // gebe fehlermeldungen aus, wenn was schiefgelaufen ist
        $this->_handleErrors($stmt);

        return $result;
    }

    public function insert($params)
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
        $stmt = $this->prepare($sql);
        // führe über execute das SQL kommando aus anhand der parameter in $params
        $result = $stmt->execute($params);
        // gebe fehlermeldungen aus, wenn was schiefgelaufen ist
        $this->_handleErrors($stmt);

        return $this->lastInsertId();
    }

    public function delete($id) {
        $sql = 'DELETE FROM '. $this->table. ' WHERE id = ?';
        $stmt = $this->prepare($sql);
        return $stmt->execute( [ $id ] );
    }
}
?>
