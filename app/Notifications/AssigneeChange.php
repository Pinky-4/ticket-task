<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssigneeChange extends Notification
{
    use Queueable;

    public $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket_data)
    {
        $this->ticket = $ticket_data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = $this->ticket->title;
        $status = $this->ticket->status == '1' ? 'Pending' : 'Closed';
        return (new MailMessage)
                    ->line("Ticket: {$title}. Current Status is {$status}. Now you are assigned to this ticket. You have to take care this.")
                    ->action('Click Here to View', route('ticket.show',$this->ticket->id))
                    ->line('Thank you for using our ticketing application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
