<?php

namespace App\Observers;

use App\Models\V1\Device;
use App\Models\V1\User;
use App\Notifications\DeviceUpdatedNotification;

class DeviceObserver
{
    public function updated(Device $device): void
    {
        $users = User::where('role', 'superAdmin')->get();

        foreach ($users as $user) {
            $user->notify(new DeviceUpdatedNotification($device));
        }
    }
}
