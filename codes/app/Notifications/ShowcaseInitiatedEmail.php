<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ShowcaseInitiatedEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($orderid)
    {
        $this->orderid = $orderid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                        ->subject(ucwords(auth()->user()->name).', Your showcase at home order with the order number '.$this->orderid.' has been initiated!')
                        ->greeting('Hello '.ucwords(auth()->user()->name).',')
                        ->line('Thank you for choosing '.env('APP_NAME').'. We are happy to serve you!')
                        ->line('This email is to inform you that we have received your showcase at home order.')
                        ->line('Click on the below button for order information.')
                        ->action('View Order', route('showcase.ordercomplete', ['id' => $this->orderid]))
                        ->line('Thank you for using '.env('APP_URL').'!')
                    ;
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
}
