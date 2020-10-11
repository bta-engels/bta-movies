<?php
require_once 'db.php';

/**
 * Class MyDB
 */
class MyDB extends PDO {

    private $_outputFormat = PDO::FETCH_ASSOC;

    /**
     * MyDB constructor.
     * wird bei jeder instanzierung der Klasse als Objekt ausgeführt
     */
    public function __construct() {
        // DSN: data source name
        $dsn  = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options    = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        parent::__construct($dsn, DB_USERNAME, DB_PASSWORD, $options);
    }

    /**
     * @param string $sql
     * @param null $params
     * @return array
     */
    public function getAll($sql, $params = null) {
        $stmt   = $this->_prepareAndExecute($sql, $params);
        $result = $stmt->fetchAll($this->_outputFormat);
        return $result;
    }

  /**
   * @param string $sql
   * @param array|null $params
   * @return mixed
   */
    public function getOne($sql, $params = null) {
      $stmt   = $this->_prepareAndExecute($sql, $params);
      $result = $stmt->fetch($this->_outputFormat);
      return $result;
    }

    /**
     * @param string $sql
     * @param null $params
     * @return bool|PDOStatement
     */
    private function _prepareAndExecute($sql, $params = null) {
      $stmt = $this->prepare($sql);
      $stmt->execute($params);
      $this->_handleErrors($stmt);

      return $stmt;
    }

    public function _handleErrors($stmt) 
    {
      $error = $stmt->errorInfo() ?: null;
      // gibt es fehler, dann gebe sie hier aus
      if ($error && $errmsg = array_pop($error)) {
        throw new MyDBException($errmsg);
      }
    }

    /**
     * @param int $outputFormat
     * @return $this
     */
    public function setOutputFormat($outputFormat)
    {
        $this->_outputFormat = $outputFormat;
        return $this;
    }

    /**
     * @return int
     */
    public function getOutputFormat()
    {
        return $this->_outputFormat;
    }
}

class MyDBException extends PDOException {
    /**
     * Override constructor and set message and code properties.
     * Workaround PHP BUGS #51742, #39615
     */
    public function __construct($message = null, $code = null) {
        $this->message = $message;
        $this->code = $code;
    }  
}
?>
