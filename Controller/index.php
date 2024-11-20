<?php

$action = $_GET["action"] ?? 'acceuil';

switch ($action) {
    case 'acceuil':
        require(__DIR__ . "/../index.php");
        break;
    case 'signUp':
    case 'signIn':
        require(__DIR__ . "/../action.php");
        break;
}
