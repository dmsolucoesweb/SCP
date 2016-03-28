<?php

if (isset($_SESSION)) {
    session_destroy();
}

require_once '../Controllers/LoginController.php';

$LoginController = new LoginController();

unset($LoginController);
