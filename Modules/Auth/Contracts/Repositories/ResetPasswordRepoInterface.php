<?php

namespace Modules\Auth\Contracts\Repositories;

use Modules\Auth\Models\ResetSecret;

interface ResetPasswordRepoInterface
{
    /**
     * @param array $data
     * @return ResetSecret
     */
    public function create(array $data): ResetSecret;

    /**
     * @param string $email
     * @return ResetSecret|null
     */
    public function find(string $email): ?ResetSecret;

    /**
     * @param string $email
     * @param string $secret
     * @return bool
     */
    public function resetSecretIsValid(string $email, string $secret): bool;

    /**
     * reset the password
     *
     * @param string $newPassword
     * @param string $email
     * @param string $secret
     * @return bool
     */
    public function reset(
        string $newPassword,
        string $email,
        string $secret): bool;
}
