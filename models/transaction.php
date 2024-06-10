<?php

class Transaction{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;        
    }

    // Yeni bir işlemi ve ilgili öğeleri veritabanına kaydeder
    public function saveTransaction($userId,$charge,$items){
        // transactions tablosuna yeni bir kayıt ekle
        $stmt = $this->conn->prepare("INSERT INTO transactions (user_id,transaction_id,amount,currency,description,status) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("isisss", $userId,$charge->id,$charge->amount,$charge->currency,$charge->description,$charge->status);
        $stmt->execute();

        // Son eklenen işlemin ID'sini al
        $transactionId = $this->conn->insert_id;

        // Her ürün için transaction_items tablosuna kayıt ekle
        foreach($items as $productId => $quantity){
            $stmt = $this->conn->prepare("INSERT INTO transaction_items (transaction_id,product_id,quantity) VALUES (?,?,?)");
            $stmt->bind_param("iii", $transactionId,$productId,$quantity);
            $stmt->execute();
        }
        $stmt->close();
    }

    // Tüm işlemleri veya belirli bir durumdaki işlemleri getirir
    public function getTransactions($status = null) {
        if ($status) {
            $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE order_status = ? ORDER BY created_at DESC");
            $stmt->bind_param("s", $status);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM transactions ORDER BY created_at DESC");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        $stmt->close();
        return $transactions;
    }

    // Belirli bir işlemin sipariş durumunu günceller
    public function updateOrderStatus($transactionId, $status) {
        $stmt = $this->conn->prepare("UPDATE transactions SET order_status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $transactionId);
        $stmt->execute();
        $stmt->close();
    }
}

?>