<?php

class Transaction{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;        
    }

    public function saveTransaction($userId,$charge,$items){
        $stmt = $this->conn->prepare("INSERT INTO transactions (user_id,transaction_id,amount,currency,description,status) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("isisss", $userId,$charge->id,$charge->amount,$charge->currency,$charge->description,$charge->status);
        $stmt->execute();

        $transactionId = $this->conn->insert_id;

        foreach($items as $productId => $quantity){
            $stmt = $this->conn->prepare("INSERT INTO transaction_items (transaction_id,product_id,quantity) VALUES (?,?,?)");
            $stmt->bind_param("iii", $transactionId,$productId,$quantity);
            $stmt->execute();
        }
        $stmt->close();
    }
}

?>