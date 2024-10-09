<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\invoices;
class addinvoice extends Notification
{
    use Queueable;
    private $invoice_id;

    public function __construct($invoice_id)
    {
        $this->invoice_id=$invoice_id;
    }


    public function via(object $notifiable): array
    {
        return ['email'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        $url = 'http://127.0.0.1:8000/invoicesdetails/'.$this->invoice_id;

        return (new MailMessage)
                    ->subject('اضافه فاتوره جديده')
                    ->line('اضافه فاتوره جديده')
                    ->action('عرض الفاتوره',$url)
                    ->line('Thank you for using our application!');
    }


    public function toArray(object $notifiable): array
    {
        return [

        ];
    }
}
