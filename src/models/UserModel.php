<?php

namespace src\models;

use PDOException;
use src\core\Database;

class UserModel
{
    public int $id;
    public string $username;
    public string|null $profile_image;
    public string $email;
    public string $password;

    public function __construct(int $id, string $username, string $email, string $password, string|null $profile_image)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->profile_image = $profile_image;
    }

    public static function findByUserId(int $userId): ?UserModel
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
            $stmt = Database::query($sql, array(":id" => $userId));
            $userData = $stmt->fetch();

            if ($userData) {
                return new UserModel($userData['id'], $userData['username'], $userData['email'], $userData['password'], $userData['profile_image']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getImage(): string
    {
        return $this->profile_image;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function findByEmail(string $email): ?UserModel
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = Database::query($sql, array(":email" => $email));
            $userData = $stmt->fetch();

            if ($userData) {
                return new UserModel($userData['id'], $userData['username'], $userData['email'], $userData['password'], $userData['profile_image']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }
}