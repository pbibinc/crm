<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadNotesNotification extends Notification
{
    use Queueable;
    public $sender;
    public $noteTitle;
    public $noteDescription;
    public $leadId;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($noteTitle, $sender, $noteDescription, $leadId)
    {
        $this->noteTitle = $noteTitle;
        $this->sender = $sender;
        $this->noteDescription = $noteDescription;
        $this->leadId = $leadId;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->noteTitle,
            'description' => $this->noteDescription,
            'lead_id' => $this->leadId,
            'sender' => $this->sender
        ];
    }
}
