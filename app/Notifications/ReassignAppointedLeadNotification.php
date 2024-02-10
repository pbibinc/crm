<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReassignAppointedLeadNotification extends Notification
{
    use Queueable;
    public $productCount;
    public $newOwnerName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($productCount, $newOwnerName)
    {
        $this->productCount = $productCount;
        $this->newOwnerName = $newOwnerName;
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
            'message' => $this->productCount . ' ' .  'of you products have been reassigned to' . ' ' . $this->newOwnerName . '.',
            'data' => $this->productCount
        ];
    }
}