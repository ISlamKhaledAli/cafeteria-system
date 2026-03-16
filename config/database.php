<?php
class Database {
    private static $instance = null;
    private $connection;
    private $host = "localhost";
    private $username = "mostafamohamed";
    private $password = "123456";
    private $database = "cafeteria";


class Database {

    private $host = "localhost";
    private $dbname = "cafeteria";
    private $user = "root";
    private $pass = "";

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

    private function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    private function __clone() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>

