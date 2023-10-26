<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductPurchased extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $customer, $cashback, $purchase_date, $product, $review_link)
    {
        $this->customer = $customer;
        $this->order_no = $order;
        $this->purchase_date = $purchase_date;
        $this->total_amt = $total_amt;
        $this->items = $items; // Array of items
        $this->shipping_add = $shipping_add; // Array of shipping
        $this->payment_method = $payment_method; 
        $this->cashback = $cashback;
        $this->product = $product;
        $this->review_link = $review_link;
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
            ->subject('Purchase Confirmation')
            ->line('Dear ' . $this->customer)
            ->line('We are excited to confirm your recent purchase with ' . env('APP_URL'))
            ->line('Order Details:')
            ->line('Order Number: ' . $this->order_no)
            ->line('Date of Purchase: ' . $this->purchase_date)
            ->line('Total Amount: ' . $this->total_amt)
            ->line('Items Purchased:')
            ->line($this->items)
            ->line('Shipping Address:')
            ->line($this->shipping_add)
            ->line('Payment Method:')
            ->line($this->payment_method)
            ->line('If you have any questions or concerns about your order, please don’t hesitate to contact our customer support team at helpdesk@cartrefs.com ')
            ->line('Thank you for choosing '.env('APP_URL'). ' for your purchase. We appreciate your business and look forward to serving you again in the future.')
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
