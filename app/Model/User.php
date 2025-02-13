<?php

namespace Framework2f4\Model;

use Framework2f4\Database\Database;
use PDO;

class User extends BaseModel
{
    protected static string $table = 'users';

    public static function findByName(string $username): ?self
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM ' . self::$table . ' WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user ? new User($user) : null;
    }

    public function getPassword(): string
    {
        return $this->attributes['password'] ?? '';
    }
}