<?php
namespace App\Notifications;

use App\Models\V1\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class DeviceUpdatedNotification extends Notification implements ShouldQueue
{
use Queueable;

protected $device;

/**
* Create a new notification instance.
*/
public function __construct(Device $device)
{
$this->device = $device;
}

/**
* Get the notification's delivery channels.
*
* @return array<int, string>
*/
public function via(object $notifiable): array
{
return ['mail', 'database'];
}

/**
* Get the mail representation of the notification.
*/
public function toMail(object $notifiable): MailMessage
{
return (new MailMessage)
->from(config('mail.from.address'), config('mail.from.name'))
->line('Device number ' . $this->device->id . ' has been updated by ' . Auth::user()->name)
->action('View Device', url('/devices/' . $this->device->id));
}

/**
* Get the array representation of the notification.
*
* @return array<string, mixed>
*/
public function toArray(object $notifiable): array
{
return [
'device_id' => $this->device->id,
'serial_number' => $this->device->serial_number,
'warehouse_id' => $this->device->warehouse->id,
'mac_address' => $this->device->mac_address,
'branch_id' => $this->device->branch->branch_id,
'box_number' => $this->device->box_number,
];
}
}
