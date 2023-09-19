<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PrepaidOrderEmailToVendor extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $seller)
    {
        $this->order = $order;
        $this->seller = $seller;
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
                        ->subject('New Order Alert: Order #'.$this->order->order_id)
                        ->greeting('Dear '.$this->seller->name)
                        ->line("We're pleased to inform you that you have received a new order on ".env('APP_URL'))
                        ->line('Order Number: #'.$this->order->order_id)
                        ->line('Customer: #'.ucwords(auth()->user()->name))
                        ->line('Email: #'.auth()->user()->email)
                        ->line('Please check your seller dashboard for complete order details and proceed with fulfilling the order promptly.')
                        ->line("If you have any questions or need assistance, feel free to reach out to our support team at info@cartrefs.com")
                        ->line('Thank you for being a valued seller on our platform.')
                        ->line('Best regards,')
                        ->line(env('APP_NAME'))

                        // ->line(ucwords(auth()->user()->name).' have placed an prepaid order on '.env('APP_URL'))
                        // ->line('Click on the below button to view new orders.')
                        // ->action('View New Orders', url('/'.Config::get('icrm.admin_panel.prefix').'/orders?label=New Order'))
                        // ->line('Thank you for using '.env('APP_URL').'!')
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
