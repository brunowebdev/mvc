<?php


class db {
    
    private $conn;
    
    function __construct() {
        $this->conn = new PDO('mysql:host=localhost;port=3306;dbname=pdo-test', 'root', 'root');
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function connect(){
        return $this->conn;
    }
}
