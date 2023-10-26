<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderAccepted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $customer, $seller, $items, $seller_contact)
    {
        $this->customer = $customer;
        $this->seller = $seller;
        $this->order_no = $order;
        $this->items = $items;
        $this->seller_contact = $seller_contact;
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
            ->subject('Your Order Accepted by the seller')
            ->line('Dear ' . $this->customer)
            ->line('We are delighted to inform you that your order with '. $this->seller .' has been accepted and is currently being prepared for delivery. ')
            ->line('Order Details:')
            ->line('Order Number: ' . $this->order_no)
            ->line('Items in Order: '.$this->items)
            ->line('Estimated Delivery Time: Approximately 3 hours from now')
            ->line('Our team is working diligently to ensure a swift and accurate delivery of your items. You can expect your order to arrive at your doorstep within the next 3 hours.')
            ->line('Should you have any questions or require further assistance, please do not hesitate to reach out to us at '.$this->seller_contact)
            ->line('Thank you for choosing '. $this->seller .' for your purchase. We look forward to delivering your order promptly.')
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
