<?php

namespace App\Notifications;

use App\Models\Invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInvoiceNotification extends Notification
{
    use Queueable;
    public $invoice;
    /**
     * Create a new notification instance.
     */
    public function __construct(Invoices $invoice)
    {
        $this->invoice = $invoice;
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
            'invoice_id' => $this->invoice->id,
            'title' => 'New Invoice',
            'user' => auth()->user()->name,
        ];
    }
}
