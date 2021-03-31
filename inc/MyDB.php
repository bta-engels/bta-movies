<?php
require_once 'db.php';
require_once 'MyDBException.php';
/*
require_once 'Models/Author.php';
require_once 'Models/Movie.php';
require_once 'Models/User.php';
*/
/**
 * Class MyDB
 */
class MyDB extends PDO
{

    protected $class;
    /**
     * @var int
     */
    private $_outputFormat = PDO::FETCH_OBJ;

    /**
     * MyDB constructor.
     * wird bei jeder instanzierung der Klasse als Objekt ausgeführt
     */
    public function __construct()
    {
        // DSN: data source name
        $dsn  = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options    = array(
            // gib abfrage ergenisse mit dem zechensatzt 'utf8' aus
            PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES utf8',
            // einen einzelnen datensatz nur als assoziatives array ausgeben
            PDO::ATTR_DEFAULT_FETCH_MODE    => $this->_outputFormat,
            // bei auftretenden fehlern exceptions ausgeben
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES      => true,
        );
        parent::__construct($dsn, DB_USERNAME, DB_PASSWORD, $options);
    }

    /**
     * @param string $sql
     * @param null $params
     * @return array|bool
     */
    public function getAll(string $sql, array $params = null)
    {
        $stmt   = $this->prepareAndExecute($sql, $params);
        $result = $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->class);
        return $result;
    }

  /**
   * @param string $sql
   * @param array|null $params
   * @return array|bool
   */
    public function getOne(string $sql, array $params = null)
    {
        $stmt   = $this->prepareAndExecute($sql, $params);
        $result = $stmt->fetchObject($this->class);
        return $result;
    }

    /**
     * @param string $sql
     * @param null $params
     * @return bool|PDOStatement
     */
    protected function prepareAndExecute($sql, $params = null) : PDOStatement
    {
        $stmt = $this->prepare($sql);
//        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->class);
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
