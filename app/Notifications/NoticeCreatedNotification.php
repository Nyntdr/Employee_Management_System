<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NoticeCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $notice;
    public function __construct($notice)
    {
        $this->notice=$notice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
           'title' => $this->notice->title,
           'content' => $this->notice->content,
           'poster' => $this->notice->poster->name,
           'message' => $this->notice->poster->name. ' has posted a notice titled: '.$this->notice->title,
        ];
    }
}
