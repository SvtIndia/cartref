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
                        ->line('Confirmation Number: '.$this->order->order_id)
                        ->line('We’re happy to let you know that we’ve received your order.')
                        ->line('Once your package ships, we will send you an email with a tracking number and link so you can see the movement of your package.')
                        ->line('If you have any questions, contact us here or call us on +91-8447923903')
                        ->line('We are here to help!')
                        ->line('Returns: If you would like to return your product(s), please see here' .route('ordercomplete', ['id' => $this->order->order_id]). 'or contact us.')
                        // ->line('Thank you for choosing '.env('APP_NAME').'. We are happy to serve you!')
                        // ->line('This email is to inform you that we have received your prepaid order for '.Config::get('icrm.currency.icon').number_format($this->order->order_total, 2).'/-')
                        // ->line('Click on the below button for order information and tracking.')
                        // ->action('View Order', route('ordercomplete', ['id' => $this->order->order_id]))
                        // ->line('Thank you for using '.env('APP_URL').'!')
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
