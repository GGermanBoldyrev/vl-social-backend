<?php

namespace src\controllers;

use src\models\UserModel;

class LoginController
{
    public function store(array $params, array $requestData): void
    {
        $email = $requestData['email'];
        $password = $requestData['password'];

        if (empty($email) || empty($password)) {
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Email and password are required']);
            return;
        }

        $user = UserModel::findByEmail($email);

        if (!$user) {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid username/email or password']);
            return;
        }

        // Verify that the provided password matches the stored hashed password
        if (!password_verify($password, $user->getPassword())) {
            http_response_code(401); // Unauthorized
            echo json_encode(['message' => 'Invalid username/email or password']);
            return;
        }

        http_response_code(200); // OK
        echo json_encode(["user_id" => $user->getId(), 'message' => 'Authentication successful']);
    }
}