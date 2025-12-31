<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AssetUpdatedNotification extends Notification
{
    use Queueable;

    protected $asset;

    public function __construct($asset)
    {
        $this->asset = $asset;
    }

    public function via($notifiable) : array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Your asset request ".$this->asset->name." has been rejected by the admin/HR.",
        ];
    }
}
