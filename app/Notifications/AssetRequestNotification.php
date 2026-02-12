<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AssetRequestNotification extends Notification
{
    use Queueable;

    protected $asset;

    public function __construct($asset)
    {
        $this->asset = $asset;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $requester = $this->asset->requestedBy;

        $employeeName = $requester ? $requester->full_name : 'Unknown Employee';

        $reason = $this->asset->request_reason ?? 'No reason provided';

        return [
            'employee_id'   => $requester?->employee_id,
            'employee_name' => $employeeName,
            'reason'        => $reason,
            'asset_id'      => $this->asset->asset_id,
            'asset_name'    => $this->asset->name,
            'status'        => 'requested',
            'message'       => "{$employeeName} requested asset: {$this->asset->name}"
                . ($reason !== 'No reason provided' ? " (Reason: {$reason})" : ''),

        ];
    }

}
