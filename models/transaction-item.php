<?php

class TransactionItem {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Belirli bir işlemdeki ürünleri getirir
    public function getItemsByTransactionId($transactionId) {
        $stmt = $this->conn->prepare("SELECT product_id FROM transaction_items WHERE transaction_id = ?");
        $stmt->bind_param("i", $transactionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row['product_id'];
        }
        $stmt->close();
        return $items;
    }
}
?>
