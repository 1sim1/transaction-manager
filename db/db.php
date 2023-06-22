<?php
// class Database {
//     public $host = "localhost";
//     public $db_name = "pwg_project1_db";
//     public $user_name = "root";
//     public $password = "";
//     public $conn = "";

//     public function getConnection() {
//         try {
//             $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user_name, $this->password);
//             $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//             return $this->conn;
//         } catch(PDOException $e) {
//             echo "Connessione al database fallita: " . $e->getMessage();
//         }
//     }

//     public function closeConnection() {
//         $this->conn = null;
//         echo "Connessione al DB terminata.";
//     }
// }
?>