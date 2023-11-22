<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ShowroomAtHomeOrder extends Notification
{
    use Queueable;
    public $order_no;
    public $seller;
    public $customer_name;
    public $customer_email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $seller, $customer_name, $customer_email)
    {
        $this->order_no = $order;
        $this->seller = $seller;
        $this->customer_name = $customer_name;
        $this->customer_email = $customer_email;
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
            ->subject('Showroom At Home Order')
            ->line('Dear ' . $this->seller)
            ->line('We’re pleased to inform you that you have received a new Showroom at Home order on Cartrefs.com')
            ->line('Order Number: ' . $this->order_no)
            ->line('Customer: ' . $this->customer_name)
            ->line('Email: ' . $this->customer_email)
            ->line('Please check your seller dashboard for complete order details and proceed with fulfilling the order promptly. Your are request to kindly pack and handover the ordered products to a cartrefs certified delivery boy only. Kindly check his name and mobile number on your seller dashboard.')
            ->line('If you have any questions or need assistance, feel free to reach out to our support team at info@cartrefs.com')
            ->line('Thank you for being a valued seller on our platform.')
//            ->line('Best regards')
//            ->line(env('APP_URL'))
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
