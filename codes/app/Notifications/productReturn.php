<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductReturn extends Notification
{
    use Queueable;
    public $order;
    public $customer;
    public $product;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $customer ,$product)
    {
        $this->order = $order;
        $this->customer = $customer;
        $this->product = $product;
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
        // dd($this->order->customer_name);
        return (new MailMessage)
            ->subject('Hello '.$this->customer)
            ->line('We have received your return request. Thank you for the information!')
            ->line('You can now prepare your return package and wait for the courier to pick it up.')
            ->line('As soon as we receive the package from you with the returned '.$this->product.' we will refund your money. Refunds take a maximum of 5-7 business days.')
            ->line('Regards,')
            ->line('The '.env('APP_URL').' Team')
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
