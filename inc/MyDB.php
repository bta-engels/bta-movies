<?php
require_once 'db.php';
require_once 'MyDBException.php';

/**
 * Class MyDB
 */
class MyDB extends PDO {

    /**
     * @var int
     */
    private $_outputFormat = PDO::FETCH_ASSOC;

    /**
     * MyDB constructor.
     * wird bei jeder instanzierung der Klasse als Objekt ausgeführt
     */
    public function __construct() {
        // DSN: data source name
        $dsn  = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options    = array(
            PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES utf8',
            PDO::ATTR_DEFAULT_FETCH_MODE    => $this->_outputFormat,
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        );
        parent::__construct($dsn, DB_USERNAME, DB_PASSWORD, $options);
    }

    /**
     * @param string $sql
     * @param null $params
     * @return array
     */
    public function getAll(string $sql, array $params = null) : array {
        $stmt   = $this->prepareAndExecute($sql, $params);
        $result = $stmt->fetchAll($this->_outputFormat);
        return $result;
    }

  /**
   * @param string $sql
   * @param array|null $params
   * @return array|bool
   */
    public function getOne(string $sql, array $params = null) : array {
      $stmt   = $this->prepareAndExecute($sql, $params);
      $result = $stmt->fetch($this->_outputFormat);
      return $result;
    }

    /**
     * @param string $sql
     * @param null $params
     * @return bool|PDOStatement
     */
    protected function prepareAndExecute($sql, $params = null) : PDOStatement {
      $stmt = $this->prepare($sql);
      $stmt->execute($params);
      $this->handleErrors($stmt);

      return $stmt;
    }

    /**
     * @param PDOStatement $stmt
     */
    public function handleErrors(PDOStatement $stmt)
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
?>
