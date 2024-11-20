<?php

require_once __DIR__ . '/../../Model/classes/User.php';

$action = $_GET["action"] ?? null;

switch ($action) {
    case "add":
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $passwordConfirm = $_POST['passwordConfirm'] ?? null;

        if (!empty($name) && !empty($email) && !empty($username) && !empty($password) && !empty($passwordConfirm) && $password === $passwordConfirm) {
            $user = new User($name, $email, $username, $password);
            $user->insertUser(
                $user->getName(),
                $user->getEmail(),
                $user->getUsername(),
                $user->getPassword()
            );
        }
}
