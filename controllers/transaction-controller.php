<?php

require_once 'models/database.php';
require_once "models/transaction.php";

class TransactionController
{
    private $transaction;

    public function __construct()
    {
        $database = new database();
        $db = $database->getConnection();
        $this->transaction = new Transaction($db);
    }

    // Yeni bir işlemi kaydetmek için Transaction modelini kullanır
    public function saveTransaction($userId, $charge, $items)
    {
        $this->transaction->saveTransaction($userId, $charge, $items);
    }

    // İşlemleri listelemek için Transaction modelini kullanır
    public function listTransactions($status = null)
    {
        return $this->transaction->getTransactions($status);
    }

    //Kullanıcının tüm işlemlerini çekmek için Transaction modelini kullanır.
    public function getTransactionsByUserId($userId)
    {
        return $this->transaction->getTransactionsByUserId($userId);   
    }

    // Sipariş durumunu güncellemek için Transaction modelini kullanır
    public function updateOrderStatus($transactionId, $status)
    {
        $this->transaction->updateOrderStatus($transactionId, $status);
    }
}