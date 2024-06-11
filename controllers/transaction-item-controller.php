<?php

require_once 'models/database.php';
require_once 'models/transaction-item.php';

class TransactionItemController {
    private $transactionItem;

    public function __construct() {
        $database = new database();
        $db = $database->getConnection();
        $this->transactionItem = new TransactionItem($db);
    }

    // Belirli bir işlemdeki ürünleri getirmek için TransactionItem modelini kullanır
    public function getAllTransactionItems($transactionId) {
        return $this->transactionItem->getAllTransactionItems($transactionId);
    }
}
?>
