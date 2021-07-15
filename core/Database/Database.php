<?php


namespace Core\Database;


use PDO;

class Database
{
    private static $instance;
    private $db;

    private function __construct()
    {
        $this->db = new PDO('mysql:host=' . $_ENV['DATABASE_HOST'] . ';dbname=' . $_ENV['DATABASE_NAME'] . ';charset=utf8',
            $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD'], [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        /*$this->db = new PDO('sqlite:../var/data.db', null, null, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);*/
    }

    public static function getInstance(): self
    {
        if (!Database::$instance) {
            Database::$instance = new Database();
        }

        return Database::$instance;
    }

    public function query(string $statement, array $parameters = [], string $classFQN = null, bool $oneResult = false)
    {
        $request = $this->db->prepare($statement);

        if ($classFQN) {
            $request->setFetchMode(PDO::FETCH_CLASS, $classFQN);
        }

        $request->execute($parameters);

        if ($oneResult) {
            return $request->fetch();
        }

        return $request->fetchAll();
    }

    public function queryUpdate(string $statement, array $parameters = [])
    {
        $request = $this->db->prepare($statement);
        $request->execute($parameters);
    }
}