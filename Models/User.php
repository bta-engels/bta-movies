<?php

require_once 'Model.php';

/**
 * Class User
 */
class User extends Model {

    protected $class = __CLASS__;
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * get try to find one user by username and password
     * @param string $username
     * @param string $password
     * @return array|bool
     */
    public function get(string $username, string $password)
    {
        $sql = "SELECT id,username FROM $this->table WHERE username = ? AND password = ?";
        return $this->getOne($sql, [$username, $password]);
    }
}
?>
