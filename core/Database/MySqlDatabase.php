<?php

namespace Core\Database;

use \PDO;
use \Core\Config;

class MySqlDatabase extends Database
{
    private $pdo;

    private function getPDO()
    {
        if ($this->pdo === null) {

            $config = Config::getInstance(ROOT . '/config/config.php');

            $pdo = new PDO('mysql:host=' . $config->get('db_host') . ';dbname=' . $config->get('db_name') . ';charset=utf8', $config->get('db_user'), $config->get('db_pass'));

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function query($statement, $className = null, $one = false)
    {
        $req = $this->getPDO()->query($statement);

        //Check type of query return req if statement is an Action
        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) {
            return $req;
        }
        if ($className === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $className);
        }

        if ($one) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }

        return $datas;
    }

    public function prepare($statement, $attributes, $className = null, $one = false)
    {
        $req = $this->getPDO()->prepare($statement);
        $res = $req->execute($attributes);

        //Check type of query return req if statement is an Action
        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) {
            return $res;
        }

        if ($className === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $className);
        }

        if ($one) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();

        }
        return $datas;

    }

    public function lastInsertId()
    {
        return $this->getPDO()->lastInsertId();
    }
}
