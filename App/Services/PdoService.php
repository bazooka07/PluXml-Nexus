<?php
/**
 * PdoService
 */
namespace App\Services;

/*
 * https://php.net/manual/fr/pdostatement.fetch.php
 * */
class PdoService
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DBNAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    /**
     *
     * @param String $sql
     * @return Array
     */
    public function query(String $sql)
    {
        $req = $this->pdo->prepare($sql);
        $status = $req->execute();
        return $req->fetchAll();
    }

    /**
     *
     * @param String $sql
     * @return Bool
     */
    public function insert(String $sql)
    {
        $req = $this->pdo->prepare($sql);
        return $req->execute();
    }

    /**
     *
     * @param String $sql
     * @return Bool
     */
    public function delete(String $sql)
    {
        $req = $this->pdo->prepare($sql);
        return $req->execute() !== 0;
    }
}
