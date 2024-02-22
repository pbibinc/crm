<?php

namespace App\Notifications;

use App\Models\Notifications;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Session\Session;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AssignAppointedLead extends Notification implements ShouldQueue
{
    use Queueable;
    public $productCount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($productCount)
    {
        $this->productCount = $productCount;
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

    public function broadcastOn()
    {
        return new Channel('assign-appointed-lead-notification');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You have'. ' ' . $this->productCount . ' ' .'new products to quote on.',
            'apointee_message' => 'Your Appointed Lead has been assigned to ',
            'data' => $this->productCount
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'type' => 'Assigned Appointed Lead',
            'data' => [
                'message' => 'You have'. $this->productCount .'new products to quote on.'
            ],
        ]);
    }
}