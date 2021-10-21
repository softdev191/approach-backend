<?php

namespace App\Jobs;

use App\Models\Nudge;
use App\Service\SnsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendMissedNudgesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deviceTokenRepository;

    protected $nudge;

    public function __construct($nudge)
    {
        $this->deviceTokenRepository = app('App\Repositories\DeviceTokenRepository');
        $this->nudge = $nudge;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug(["job called!"]);
            // GET ARN INFO OF RECEIVER

        if($this->nudge){
            $credentials = $this->deviceTokenRepository->getUserDevices($this->nudge->to_user_uuid);

            if($credentials){
                $sns = new SnsService();
                foreach ($credentials as $credential){

                    $data = [
                        'id' => $credential->id,
                        'platform' => $credential->platform,
                        'arn' => $credential->arn,
                        'user_uuid' => $credential->user_uuid,
                        'title' => 'You missed a nudge!',
                        'type' => 'missed-nudge',
                        'payload' => [
                            'uuid' => $this->nudge->from_user_uuid,
                        ]
                    ];
                    $sns->sendNotification($data);
                }
            }
        }
    }
}
