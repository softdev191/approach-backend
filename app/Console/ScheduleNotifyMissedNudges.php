<?php


namespace App\Console;


use App\Jobs\SendMissedNudgesJob;
use App\Repositories\DeviceTokenRepository;
use App\Repositories\NudgeRepository;
use App\Service\SnsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ScheduleNotifyMissedNudges extends Command
{
    protected $signature = "dispatch:notify_missed_nudges";

    protected $nudgeRepository;

    public function __construct(NudgeRepository $nudgeRepository )
    {
        $this->nudgeRepository = $nudgeRepository;
        parent::__construct();
    }

    public function handle()
    {
        $expiredNudges = $this->nudgeRepository->getMissedNudgesForNotification();
        Log::debug(["dispatched!"]);
        if($expiredNudges) {
            foreach ($expiredNudges as $nudge) {
                Log::debug(["expiredNudges!"]);
                Bus::dispatch((new SendMissedNudgesJob($nudge))
                    ->onConnection('sqs')
                    ->onQueue('approach-notification-queue'));
            }

        }

    }
}
