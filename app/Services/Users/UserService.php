<?php

namespace App\Services\Users;

use App\Interfaces\CalculatorInterface;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function createUser(array $userData): User
    {
        /** @var User $user */
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'email_verified_at' => now(),
            'password' => bcrypt($userData['password']),
        ]);

        return $user;
    }

    public function updateUser(User $user, array $userData)
    {
    }

    public function deleteUser(User $user)
    {
    }

    public function getUser(int $userId): ?User
    {
        return User::find($userId);
    }

    public function getUsers(): iterable
    {
        return User::paginate(20);
    }
}
