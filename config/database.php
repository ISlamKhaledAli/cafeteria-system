<?php

class Database {

    private $host = "localhost";
    private $dbname = "cafeteria";
    private $user = "mostafamohamed";
    private $pass = "123456";

    public function connect(){

        try{

            $pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                $this->user,
                $this->pass
            );

            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $pdo;

        }catch(PDOException $e){

            die("Database Error: ".$e->getMessage());

        }
    }

}