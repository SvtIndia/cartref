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
    public function __construct($customer,$product,$review_link)
    {
        $this->customer = $customer;
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
            ->subject('Quick Follow-Up: Your Recent Purchase')
            ->line('Hi ' . $this->customer)
            ->line('We just wanted to follow up on your recent purchase. We hope you’re loving your new '.$this->product.'from '.env('APP_URL').'. If you haven’t had a chance yet, we’d greatly appreciate it if you could take a moment to share your thoughts with a review.')
            ->line('Here: '.$this->review_link)
            ->line('Your feedback helps us serve you better and assists others in finding the perfect products.')
            ->line('Thank you for choosing us!')
            ->line('Warm regards,')
            ->line(env('APP_URL'))
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
