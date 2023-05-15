<?php

namespace Modules\Auth\Contracts\Repositories;

use Modules\Auth\Models\User;

interface UserRepositoryInterface
{
    /**
     * find the user by id
     */
    public function find(int $id): User|null;

    /**
     * find the user by id
     */
    public function findByEmail(string $email): User|null;

    /**
     * create a user in the repository
     */
    public function create(array $data): User;

    /**
     * update the user data in repository
     */
    public function update(User $user, array $newData): bool;

    /**
     * add secret code to repository for the user
     */
    public function addSecret(string $code, User $user): bool;

    /**
     * checks weather the email address is already exists in database
     */
    public function emailExists(string $email): bool;

    /**
     * @param User $user
     * @param string $secret
     * @return bool
     */
    public function secretMatches(User $user, string $secret): bool;

    /**
     * checks if login credentials match or not
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function loginCredentialsMatch(string $email, string $password): bool;
}
