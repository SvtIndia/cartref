<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CodOrderEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order,$courier_co,$trackings)
    {
        $this->order = $order; //order number
        $this->courier_co = $courier_co;
        $this->trackings = $trackings;
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
            ->subject('Your order '.$this->order.' has shipped!')
            ->line('It’s being shipped with '.$this->courier_co)
            ->line('Here’s a tracking number that you can use to check the location of your package:'.  $this->trackings .' (please note that tracking may take up to one business day to activate).')
            ->line('Thank you for placing your order!')


            // ->line('Confirmation Number: ' . $this->order->order_id)
            // ->line('We’re happy to let you know that we’ve received your order.')
            // ->line('Once your package ships, we will send you an email with a tracking number and link so you can see the movement of your package.')
            // ->line('If you have any questions, contact us here or call us on +91-8447923903')
            // ->line('We are here to help!')
            // ->line('Returns: If you would like to return your product(s), please see here ' . route('ordercomplete', ['id' => $this->order->order_id]) . ' or contact us.')
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
