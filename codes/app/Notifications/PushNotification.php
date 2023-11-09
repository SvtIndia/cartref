<?php

namespace App\Notifications;
use Pusher\Pusher;

class PushNotification
{
    protected $user_id;
    protected $data;
    protected $pusher;
    protected $channel = 'my-channel';
    protected $event = 'my-event';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pusher = new Pusher(
            env("PUSHER_APP_KEY"),
            env("PUSHER_APP_SECRET"),
            env("PUSHER_APP_ID"),
            array('cluster' => env("PUSHER_APP_CLUSTER"))
        );
  
    }

    public function send($user_id = null, $data){
        
        if(isset($user_id)){
            $this->channel .= '@'.$user_id;
        }

        $this->pusher->trigger($this->channel, $this->event, array('data' => $data));
    }

}