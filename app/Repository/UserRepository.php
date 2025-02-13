<?php

namespace Framework2f4\Repository;

use Framework2f4\Model\User;

class UserRepository
{
    public function findByUsername(string $username): ?User
    {
        return User::findByName($username);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function createUser(string $username, string $password, string $role): void
    {
        $user = new User([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => $role
        ]);
        $user->save();
    }

    public function updateUser(int $id, string $username, string $password, string $role): void
    {
        $user = User::find($id);
        if ($user) {
            $user->username = $username;
            $user->password = password_hash($password, PASSWORD_BCRYPT);
            $user->role = $role;
            $user->save();
        }
    }

    public function deleteUser(int $id): void
    {
        $user = User::find($id);
        $user?->delete();
    }
}