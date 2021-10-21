<?php

namespace App\Listeners;

use App\Events\SendNotificationEvent;
use App\Service\SnsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNotificationListener implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  SendNoticationEvent  $event
     * @return void
     */
    public function handle(SendNotificationEvent $event)
    {
        $sns = new SnsService();
        if($event->data){
            $sns->sendNotification($event->data);
        }
    }
}
