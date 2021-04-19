<?php

namespace App\Traits;

trait TokenAPI
{
    private function createToken($user)
    {
        return $user->createToken("{$user->name} - Login");
    }

    private function deleteAllToken($user)
    {
        $user->tokens()->delete();
    }

    private function regenerateToken($user)
    {
        $this->deleteAllToken($user);
        return $this->createToken($user);
    }
}
