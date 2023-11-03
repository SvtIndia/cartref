<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CartrefCredit extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order,$customer,$cashback,$purchase_date,$product,$review_link)
    {
        $this->customer = $customer;
        $this->cashback = $cashback;
        $this->purchase_date = $purchase_date;
        $this->order = $order;
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
            ->subject('Cashback Credited to Your Wallet!')
            ->line('Dear ' . $this->customer)
            ->line('We have some great news! We’re excited to let you know that you’ve received a cashback credit in your wallet as a reward for your recent purchase with '.env('APP_URL'))
            ->line('Cashback Amount: '.$this->cashback.'Original')
            ->line('Order Number: '.$this->order)
            ->line('Date of Purchase: '.$this->purchase_date)
            ->line('Your cashback is now available in your cartrefs customer wallet and can be used for your next purchase. Shop for your favorite products and enjoy the savings!')
            ->line('To use your cashback, simply choose "Wallet" as your payment method during checkout, and the amount will be applied automatically.')
            ->line('Thank you for choosing us for your shopping needs. We hope you enjoy your cashback and continue to have a great shopping experience with us!')
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
