<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use app\Models\invoices;
use Illuminate\Support\Facades\Auth;

class add extends Notification
{
    use Queueable;
    private $invoices;

    public function __construct(invoices $invoices)
    {
        $this->invoices=$invoices;

    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }



    public function toDatabase(object $notifiable): array
    {
        return [

            'id'=>$this->invoices->id,
            'tittle'=>'تم اضافه فاتوره بواسطه',
            'user'=> Auth::user()->name,
          ];
    }
}
