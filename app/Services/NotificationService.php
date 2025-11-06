<?php
namespace App\Services;

use App\Notifications\GenericNotification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Notify a user with a generic notification.
     *
     * @param  mixed  $user  (Eloquent user model)
     * @param  string $type
     * @param  array  $data
     * @return void
     */
    public static function notifyUser($user, string $type, array $data = [])
    {
        if (! $user) {
            return;
        }

        try {
            $user->notify(new GenericNotification($type, $data));
        } catch (\Throwable $e) {
            Log::error('NotificationService::notifyUser error: ' . $e->getMessage());
        }
    }
}
