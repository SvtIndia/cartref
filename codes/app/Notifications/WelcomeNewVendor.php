<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNewVendor extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vendor)
    {
        $this->brand_name = $vendor->brand_name;
        $this->contact_name = $vendor->contact_name;
        $this->contact_number = $vendor->contact_number;
        $this->email_address = $vendor->email_address;
        $this->registered_company_name = $vendor->registered_company_name;
        $this->gst_number = $vendor->gst_number;
        $this->marketplaces = $vendor->marketplaces;
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
                    ->cc(setting('notifications.cc_all_emails'))
                    ->subject(ucwords($this->contact_name).', Welcome to '.env('APP_NAME'))
                    ->greeting('Hello '.ucwords($this->contact_name).',')
                    // ->line('Welcome to '.env('APP_NAME'))
                    ->line('We are happy to see your interest in becoming our official seller.')
                    ->line('This email is to inform you that we have received your below-mentioned information and our seller management team will contact you soon.')
                    ->line('Information Received:')
                    ->line('Brand name: '.$this->brand_name)
                    ->line('Contact name: '.$this->contact_name)
                    ->line('Contact number: '.$this->contact_number)
                    ->line('Email address: '.$this->email_address)
                    ->line('Registered company name: '.$this->registered_company_name)
                    ->line('GST number: '.$this->gst_number)
                    ->line('Listed on other marketplaces?: '.$this->marketplaces)
                    ->action('Visit Us', url('/'))
                    ->line('Thank you for using our platform!');
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
