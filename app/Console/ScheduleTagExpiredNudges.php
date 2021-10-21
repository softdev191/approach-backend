<?php


namespace App\Console;


use App\Jobs\SendMissedNudgesJob;
use App\Jobs\TagExpiredNudgesJob;
use App\Repositories\DeviceTokenRepository;
use App\Repositories\NudgeRepository;
use App\Service\SnsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ScheduleTagExpiredNudges extends Command
{
    protected $signature = "dispatch:tag_expired_nudges";

    protected $nudgeRepository;

    public function __construct(NudgeRepository $nudgeRepository )
    {
        $this->nudgeRepository = $nudgeRepository;
        parent::__construct();
    }

    public function handle()
    {
        $expiredNudges = $this->nudgeRepository->getExpiredNudges();
    }
}
