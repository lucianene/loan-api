<?php

namespace LoanApi\Core\Database;

use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;

class Database implements Locatable
{
    use ContainerTrait;

    private $host;
    private $database;
    private $user;
    private $password;
    private $connection;
    private $statement = null;

    public function __construct()
    {
        // load configuration file
        $file = config_dir('/database.php');
        if(!file_exists($file)) {
            throw new Exception("File $file not found.");
        }
        $dbConfig = require_once($file);

        // setup instance variables
        $this->host = $dbConfig['host'];
        $this->database = $dbConfig['database'];
        $this->user = $dbConfig['user'];
        $this->password = $dbConfig['password'];

        // start the connection
        $this->connect();
    }

    public function connect()
    {
        try {
            $this->connection = new \PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=UTF8", $this->user, $this->password);
        } catch(\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function query($queryString)
    {
        $statement = $this->connection->prepare($queryString);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_ASSOC);

        $this->statement = $statement;

        return $this;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }
}
