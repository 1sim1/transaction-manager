<?php
class TransactionEntity {
    private $db;
    private $conn;
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
     public function insertTransaction($date_transaction, $check_value, $description, $amount) {
        try {
            $this->conn->beginTransaction();
            $qry = "INSERT INTO TRANSACTION VALUES(:date_transaction, :check_value, :description, :amount)";
            $stmt = $this->conn->prepare($qry);
            $stmt->bindParam(":date_transaction", $date_transaction, PDO::PARAM_STR);
            $stmt->bindParam(":check_value", $check_value, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":amount", $amount, PDO::PARAM_STR);
            $stmt->execute();
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo $e->getMessage();
            throw new Exception($e->getMessage());
        }
    }
}