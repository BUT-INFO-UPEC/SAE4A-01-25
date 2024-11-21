<?php

$action = $_GET["action"] ?? 'acceuil';

switch ($action) {
    case 'acceuil':
        header("Location: ../index.php"); // redirection
        break;
    case 'signUp':
    case 'signIn':
        require(__DIR__ . "/../action.php");
        break;
}
