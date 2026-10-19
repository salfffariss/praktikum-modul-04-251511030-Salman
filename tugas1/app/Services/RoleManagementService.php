<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class RoleManagementService
{
    public function changeRole(User $actor, User $target, string $newRole): void
    {
        // Admin dilarang mengubah role akunnya sendiri atau akun admin lain
        if ($actor->is($target) || $target->role === 'admin') {
            throw ValidationException::withMessages([
                'role' => 'Akun admin tidak dapat diubah di fitur ini.',
            ]);
        }

        // Jika role target sama dengan role baru, jangan lakukan save
        if ($target->role === $newRole) {
            return;
        }

        // Simpan perubahan role
        $target->role = $newRole;
        $target->save();
    }
}