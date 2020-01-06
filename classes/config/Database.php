<?php
class Database{

    private $host = '127.0.0.1';
    private $username = 'federicoflores13';
    private $password = 'kakilala1398';
    protected $dbname = 'php_oop_crud';
    private $charset = 'utf8mb4';
    private $conn;

    public function connect(){

        $this->conn = null;

        try{
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=' . 
            $this->charset;

            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


        }catch(PDOException $e){
            echo 'connection failed: ' . $e->getMessage();
        }

        return $this->conn;

    }

}