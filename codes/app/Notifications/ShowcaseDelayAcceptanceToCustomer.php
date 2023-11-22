<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ShowcaseDelayAcceptanceToCustomer extends Notification
{
    use Queueable;
    public  $order;
    /**
     * Create a new message instance.
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
            ->subject('Apology for Unfilled Delivery to Location Unserviceability')
            ->greeting('Dear '.ucwords($this->order->customer_name).',')
            ->line('I hope this message finds you well. We regret to inform you that, unfortunately, we are unable to deliver your order #' .$this->order->order_id. ' as scheduled due to current unserviceability at your location.')
            ->line('Our team has encountered unforeseen challenges that are temporarily preventing us from reaching your address. Please be assured that we are actively working to resolve this issue and anticipate being able to serve you within the next 24-48 hours.')
            ->line('We understand the inconvenience this delay may cause, and we sincerely apologize for any frustration or disappointment it may have caused. Your satisfaction is of utmost importance to us, and we want to assure you that every effort is being made to expedite the delivery process.')
            ->line('Once again, we apologize for any inconvenience caused and look forward to the opportunity to serve you promptly.')
            ->line('Thank you for your patience and continued support.')
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
