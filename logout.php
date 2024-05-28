<?php
require_once 'controllers/user-controller.php';
session_start();

$userController = new UserController();
$userController->logout();
?>