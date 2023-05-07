<?php

namespace App\Services\Users;

use App\Models\User;

interface UserServiceInterface
{
    public function createUser(array $userData): User;

    public function updateUser(User $user, array $userData);

    public function deleteUser(User $user);

    public function getUser(int $userId): ?User;

    public function getUsers(): iterable;
}
