<?php

class Category{

    private $conn;
    private $table_name = 'categories';

    // properties or fields
    public $id;
    public $name;

    public function __construct($conn = null){
        $this->conn = $conn;
    }

    public function read(){
        $query = 'SELECT id,name FROM ' . $this->table_name . ' ORDER BY name';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result =  $stmt->fetchAll();
        
        return $result;
    }

    public function readById(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id=? LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        return $stmt->fetch();
    }

}