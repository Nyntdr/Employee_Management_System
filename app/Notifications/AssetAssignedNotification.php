<?php

namespace App\Notifications;

use App\Models\Asset;
use App\Models\AssetAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AssetAssignedNotification extends Notification
{
    use Queueable;

    protected $assignment;
    protected $asset;

    public function __construct(AssetAssignment $assignment, Asset $asset)
    {
        $this->assignment = $assignment;
        $this->asset = $asset;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'assignment_id' => $this->assignment->assignment_id,
            'asset_id' => $this->asset->asset_id,
            'asset_name' => $this->asset->name,
            'asset_code' => $this->asset->asset_code,
            'assigned_date' => $this->assignment->assigned_date,
            'assigned_by' => $this->assignment->assigner->name ?? 'Admin/HR',
            'message' => "Asset '{$this->asset->name}' (Code: {$this->asset->asset_code}) has been assigned to you.",
        ];
    }
}
