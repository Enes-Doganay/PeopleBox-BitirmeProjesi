<?php 

class database{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "bookstore";

    public $conn;

    public function getConnection(){
        $this->conn = null;
        
        $this->conn = new mysqli($this->host,$this->username,$this->password,$this->db);

        if($this->conn->connect_error){
            error_log("Connection error : ". $this->conn->connect_error);
            return null;
        }

        return $this->conn;
    }
}

?>