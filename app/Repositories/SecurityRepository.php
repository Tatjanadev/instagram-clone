<?php

namespace App\Repositories;

use App\Models\User;

class SecurityRepository
{
    /**
     * @return array<int, array{
     *     id: mixed,
     *     name: mixed,
     *     authenticator: mixed,
     *     created_at_diff: string,
     *     last_used_at_diff: string|null
     * }>
     */
    public function getPasskeys(User $user): array
    {
        return $user
            ->passkeys()
            ->select(['id', 'name', 'credential', 'created_at', 'last_used_at'])
            ->latest()
            ->get()
            ->map(fn ($passkey) => [
                'id' => $passkey->id,
                'name' => $passkey->name,
                'authenticator' => $passkey->authenticator,
                'created_at_diff' => $passkey->created_at->diffForHumans(),
                'last_used_at_diff' => $passkey->last_used_at?->diffForHumans(),
            ])
            ->values()
            ->all();
    }

    public function updatePassword(User $user, string $password): void
    {
        $user->update([
            'password' => $password,
        ]);
    }
}
