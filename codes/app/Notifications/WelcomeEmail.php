<?php

namespace App\Notifications;

use App\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request)
    {        
        $this->name = $request->name;
        $this->email = $request->email;
        // $this->emailcontent = EmailNotification::where('status', 1)->where('event', 'Order Placed Email')->first()->content;
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
                    ->subject($this->name.', Welcome to '.env('APP_NAME').'!')
                    ->greeting('Dear '.$this->name.',')
                    ->line('We welcome you to our '.env('APP_NAME').' family!')
                    ->line('You registered successfully with your email address : '.$this->email)
                    ->action('Visit '.env('APP_URL'), url('/'))
                    ->line('Thank you for using '.env('APP_NAME').'!')
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
