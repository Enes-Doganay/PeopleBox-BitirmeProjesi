<?php

use Stripe\Charge;

require_once 'models/database.php';
require_once "models/transaction.php";

class TransactionController{
    private $transaction;

    public function __construct()
    {
        $database = new database();
        $db = $database->getConnection();
        $this->transaction = new Transaction($db);
    }

    public function saveTransaction($userId,$charge,$items){
        $this->transaction->saveTransaction($userId,$charge,$items);
    }
}


?>