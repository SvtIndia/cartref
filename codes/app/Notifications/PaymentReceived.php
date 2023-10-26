<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($seller, $support_email, $support_number)
    {
        $this->seller = $seller;
        $this->support_email = $support_email;
        $this->support_number = $support_number;
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
            ->subject('Payment Successfully Transferred to Your Bank Account')
            ->line('Dear ' . $this->seller)
            ->line('We’re pleased to inform you that a payment for your recent sales on our platform has been successfully transferred to your registered bank account')
            ->line('You should see this payment reflected in your bank account within the standard processing time of your financial institution. If you encounter any issues or have questions regarding this transaction, please do not hesitate to contact our support team at '.$this->support_email .' or '.$this->support_number)
            ->line('Thank you for your continued partnership with us.')
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
