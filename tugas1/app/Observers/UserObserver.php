<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function updated(User $user): void
    {
        // Jika kolom 'role' tidak berubah, jangan catat log
        if (! $user->wasChanged('role')) {
            return;
        }

        // Catat log event perubahan role tanpa memuat data sensitif
        Log::info('user.role.changed', [
            'target_user_id' => $user->id,
            'old_role'       => $user->getRawOriginal('role'),
            'new_role'       => $user->role,
            'actor_id'       => Auth::id(),
        ]);
    }
}