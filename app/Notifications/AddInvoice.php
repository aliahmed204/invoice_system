<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Invoices;

class AddInvoice extends Notification
{
    use Queueable;
    public $id;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id)
    {
        $this->id = $invoice_id;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('invoice_details.show',['invoice_detail'=>$this->id]);
        return (new MailMessage)
                    ->greeting('Welcome ')
                    ->subject('A New invoice has been Added To System')
                    ->line('create new invoice')
                    ->action('View Invoice',$url)
                    ->line('thank you for using our application');
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
