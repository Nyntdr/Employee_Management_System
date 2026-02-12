<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $event;
    public function __construct($event)
    {
        $this->event = $event;
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
            'title' => $this->event->title,
            'description' => $this->event->description,
            'event_date' => $this->event->event_date,
            'start_time' => $this->event->start_time,
            'end_time' => $this->event->end_time,
            'creator' => $this->event->creator->name,
            'message' => $this->event->creator->name. ' has declared an event titled: '.$this->event->title,
        ];
    }
}
