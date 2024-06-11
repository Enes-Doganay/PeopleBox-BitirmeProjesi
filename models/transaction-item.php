<?php

class TransactionItem
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Tüm işlem öğelerini getirir
    public function getAllTransactionItems($transactionId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM transaction_items WHERE transaction_id = ?");
        $stmt->bind_param("i", $transactionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $stmt->close();
        return $items;
    }
}