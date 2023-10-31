<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductDelivery extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $customer, $address, $tracking, $carrier = null, $delivery_date)
    {
        $this->order = $order;
        $this->customer = $customer;
        $this->address = $address;
        $this->tracking = $tracking;
        $this->carrier = $carrier;
        $this->delivery_date = $delivery_date;
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
            ->subject('Your Order Has Been Delivered!')
            ->line('Hello ' . $this->customer)
            ->line('We’re thrilled to inform you that your order with ' . env('APP_URL') . ' has been successfully delivered to the following address:')
            ->line('Delivery Address:' . $this->address)
            ->line('Order Number: ' . $this->order)
            ->line('Tracking Link: ' . $this->tracking)
            ->line('Carrier: ' . $this->carrier)
            ->line('Delivered Date: ' . $this->delivery_date)
            ->line('We hope your shopping experience with us was exceptional, and your product arrived in perfect condition. If you have any feedback or questions about your order, please donWe’t hesitate to reach out to our customer support team at ' . conifg('app.helpdesk_mail'))
            ->line('Thank you for choosing ' . env('APP_URL') . ' for your shopping needs. We look forward to serving you again in the future.')
            ->line('Best regards, ')
            ->line(env('APP_URL'))


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
