<?php

namespace App\Observers;

use App\Models\ActionDescription;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $me = auth()->user();

        if (!$me || $me->role !== "super-admin") {
            return;
        }

        // $action = ActionDescription::where('slug', 'user_created')->first();

        AuditLog::log(
            'user_created',
            [
                'admin' => $me->name,
                'role' => $me->role,
                'target' => $user->name
            ]
        );
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $me = auth()->user();

        if (!$me || $me->id === $user->id) {
            return;
        }

        $changes = $user->getChanges();
        unset($changes['updated_at']);

        if (empty($changes) || $user->wasChanged('is_active')) {
            return;
        }

        // $action = ActionDescription::where('slug', 'user_created')->first();

        AuditLog::log(
            'user_updated',
            [
                'admin' => $me->name,
                'role' => $me->role,
                'target' => $user->name
            ]
        );
    }   

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
