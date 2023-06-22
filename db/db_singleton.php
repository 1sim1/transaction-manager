<?php
class Database {
    private $host = "localhost";
    private $db_name = "pwg_project1_db";
    private $user_name = "root";
    private $password = "";
    private $conn = "";
    private static $instance = null;

    private function __construct() {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user_name, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
