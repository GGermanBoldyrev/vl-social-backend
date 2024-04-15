<?php

namespace src\controllers;

use src\interfaces\ControllerInterface;
use src\models\UserModel;

class ProfileController implements ControllerInterface
{
    public function show(array $params): void
    {
        $userid = $params['user_id'];
        $user = UserModel::findByUserId($userid);

        if (!$user) {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'User not found']);
            return;
        }

        http_response_code(200); // OK
        echo json_encode($user);
    }
}