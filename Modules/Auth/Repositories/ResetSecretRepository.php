<?php

namespace Modules\Auth\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Contracts\Repositories\ResetSecretRepositoryInterface;
use Modules\Auth\Models\ResetSecret;
use Modules\Auth\Models\User;

class ResetSecretRepository implements ResetSecretRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $data): ResetSecret
    {
        return ResetSecret::create($data);
    }

    /**
     * @inheritDoc
     */
    public function find(string $email): ?ResetSecret
    {
        return ResetSecret::where('email', $email)->first();
    }

    /**
     * @inheritDoc
     */
    public function resetSecretIsValid(string $email, string $secret): bool
    {
        $resetSecretModel = $this->find($email);

        return $resetSecretModel &&
            $resetSecretModel->secret == $secret &&
            $resetSecretModel->secret_expires_at > now() &&
            !($resetSecretModel->password_reset_happened);
    }

    /**
     * @inheritDoc
     */
    public function reset(
        string $newPassword,
        string $email,
        string $secret): bool
    {
        if (!$this->resetSecretIsValid($email, $secret)) {
            return false;
        }

        $resetSecretModel = $this->find($email);

        try {
            DB::transaction(function () use ($newPassword, $email, $resetSecretModel) {
                // fetch user
                /**
                 * @var Model $user
                 */
                $user = User::where('email', $email)->first();

                // update password
                $result = $user->update([
                    'password' => bcrypt($newPassword)
                ]);

                $resetChanged = $resetSecretModel->update([
                    'password_reset_happened' => true
                ]);
            });

            return true;
        } catch (\Exception $exception) {
            return false;
        }

    }
}
