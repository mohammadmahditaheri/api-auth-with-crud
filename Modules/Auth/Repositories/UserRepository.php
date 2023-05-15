<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Contracts\Repositories\UserRepositoryInterface;
use Modules\Auth\Models\User;

class UserRepository implements UserRepositoryInterface
{
    const EXPIRES_AFTER_IN_MIN = 5;

    public function find(int $id): User|null
    {
        return User::where('id', $id)->first();
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email = ''): User|null
    {
        if (!$email) {
            return null;
        };

        return User::where('email', $email)->first();
    }

    /**
     * @inheritDoc
     */
    public function addSecret(string $code, User $user): bool
    {
        return $user->update([
            'two_factor_secret' => $code,
            'secret_expires_at' => now()->addMinutes(self::EXPIRES_AFTER_IN_MIN)
        ]);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(User $user, array $newData): bool
    {
        try {
            return $user->update($newData);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function emailExists(string $email): bool
    {
        return (bool)User::where('email', $email)->exists();
    }

    /**
     * @inheritDoc
     */
    public function secretMatches(User $user, string $secret): bool
    {
        return $user->two_factor_secret == $secret &&
            now() < $user->secret_expires_at;
    }
}
