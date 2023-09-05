<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PrepaidOrderEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
                        ->subject(ucwords(auth()->user()->name).', Thank you for your order!')
                        ->greeting('Hello '.ucwords(auth()->user()->name).',')
                        ->line('Thank you for choosing '.env('APP_NAME').'. We are happy to serve you!')
                        ->line('This email is to inform you that we have received your prepaid order for '.Config::get('icrm.currency.icon').number_format($this->order->order_total, 2).'/-')
                        ->line('Click on the below button for order information and tracking.')
                        ->action('View Order', route('ordercomplete', ['id' => $this->order->order_id]))
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
