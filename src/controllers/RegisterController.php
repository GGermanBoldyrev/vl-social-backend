<?php

namespace src\controllers;

use src\core\Database;

class RegisterController
{
    public function store(array $params, array $requestData): void
    {
        // Extract registration data from JSON
        $username = $requestData['username'];
        $email = $requestData['email'];
        $password = $requestData['password'];
        $repeatPassword = $requestData['passwordRepeat'];

        if (empty($username) || empty($email) || empty($password) || empty($repeatPassword)) {
            http_response_code(400);
            echo json_encode(['message' => 'Username, email, password and repeat password are required']);
            return;
        }

        if ($password !== $repeatPassword) {
            http_response_code(400);
            echo json_encode(['message' => 'Passwords do not match']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid email format']);
            return;
        }

        // Check if username already exists
        $sqlCheckUsername = "SELECT COUNT(*) AS count FROM users WHERE username = :username";
        $countStatementUsername = Database::query($sqlCheckUsername, [
            ':username' => $username
        ]);
        $countResultUsername = $countStatementUsername->fetch();

        if ($countResultUsername['count'] > 0) {
            http_response_code(400);
            echo json_encode(['message' => 'Username already exists']);
            return;
        }

        // Check if email already exists
        $sqlCheckEmail = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
        $countStatementEmail = Database::query($sqlCheckEmail, [
            ':email' => $email
        ]);
        $countResultEmail = $countStatementEmail->fetch();

        if ($countResultEmail['count'] > 0) {
            http_response_code(400);
            echo json_encode(['message' => 'Email already exists']);
            return;
        }


        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

        $statement = Database::query($sql, [
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);

        if ($statement->rowCount() > 0) {
            http_response_code(201);
            echo json_encode(['message' => 'User registered successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to register user']);
        }
    }

}