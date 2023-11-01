<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewOrderMailToAdmin extends Notification
{
    use Queueable;

    public $order_no;
    public $seller;
    public $customer_name;
    public $customer_email;
    public $seller_name;
    public $seller_email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $customer_name, $customer_email, $seller_name, $seller_email)
    {
        $this->order_no = $order;
        $this->customer_name = $customer_name;
        $this->customer_email = $customer_email;

        $this->seller_name = $seller_name;
        $this->seller_email = $seller_email;

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
            ->subject('New Order Alert: '.$this->order_no)
            ->line('Hello!')
            ->line('A order has been place by a customer on cartrefs.com by '.$this->customer_name.' . The vendor of this product is '.$this->seller_name.' '.$this->seller_email)
            ->line('Order Number: '.$this->order_no)
            ->line('Customer: '.$this->customer_name)
            ->line('Email: '.$this->customer_email)
            ->line('Please check, If the seller does not responds in 24 hours kindly call him to fetch update on the order status.')
            ->line('Best regards')
            ->line(env('APP_URL'));
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
