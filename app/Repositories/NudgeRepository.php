<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\Nudge;
use App\Models\User;
use Carbon\Carbon;

class NudgeRepository extends AbstractBaseRepository
{
    public function __construct(Nudge $model)
    {
        parent::__construct($model);
    }

    public function pendingNudge($data)
    {
        return $this->model->where('from_user_uuid', $data['from_user_uuid'])
                ->where('to_user_uuid', $data['to_user_uuid'])
                ->where('status', 'pending')
                ->where('is_expired', 0)
                ->first();
    }

    public function acceptedNudge($user)
    {
        return $this->model->whereRaw("(from_user_uuid = '{$user}' OR to_user_uuid = '{$user}')")
            ->where('status', 'accepted')
            ->where('is_expired', 0)
            ->first();
    }

    public function getIncomingNudges()
    {
        return $this->model->with('user')
                           ->where('to_user_uuid', authUser()->user->uuid)
                           ->where('status', 'pending')
                           ->where('is_removed',0)
                           ->where('is_expired', 0)
                           ->get();
    }

    public function getOutgoingNudges($user)
    {
        $nudges = $this->model
                    ->where('from_user_uuid', $user)
                    ->where('is_removed',0)
                    ->where('is_expired', 0)
                    ->get();

        foreach ($nudges as $nudge)
        {
            if($nudge->from_user_uuid == $user){
                $nudge->user =  User::where('uuid', $nudge->to_user_uuid)->first();
            }else{
                $nudge->user =  User::where('uuid', $nudge->from_user_uuid)->first();
            }
        }
        return $nudges;
    }

    public function getAcceptedNudges($user)
    {
        $nudges = $this->model
            ->where('status','accepted')
            ->whereRaw("(from_user_uuid = '{$user}' OR to_user_uuid  = '{$user}')")
            ->get();

        $nudgesData = [];
        foreach ($nudges as $nudge)
        {
            if($nudge->from_user_uuid == $user){
                $nudge->user =  User::where('uuid', $nudge->to_user_uuid)->first();
            }else{
                $nudge->user =  User::where('uuid', $nudge->from_user_uuid)->first();
            }
        }
        return $nudges;
    }

    public function getNudgeFromUserToUser($user)
    {
        return $this->model->where('from_user_uuid', $user)
            ->where('to_user_uuid', authUser()->user->uuid)
            ->where('is_expired', 0)
            ->first();
    }

    public function getFromUser($user)
    {
         return $this->model->with('user')
            ->where('from_user_uuid', $user)
            ->where('to_user_uuid', authUser()->user->uuid)
            ->where('status', 'pending')
            ->where('is_removed',0)
            ->where('is_expired', 0)
            ->first();
    }

    public function getToUser($user)
    {
        return $this->model->with('toUser')
            ->where('to_user_uuid', $user)
            ->where('from_user_uuid', authUser()->user->uuid)
            ->where('status', 'accepted')
            ->where('is_expired', 0)
            ->first();
    }

    public function getNudgeFromUserToUserForCancel($user)
    {
        return $this->model->whereRaw("(
                             (from_user_uuid = '{$user}'  AND to_user_uuid = '". authUser()->user->uuid ."')
                                 OR (to_user_uuid ='{$user}' AND from_user_uuid = '". authUser()->user->uuid ."')
                         )")
                   ->whereIn('status', ['accepted','pending'])
            ->where('is_expired', 0)
            ->where('is_removed',0)
            ->first();
    }

    public function getMissedNudgesForNotification()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return $this->model->where('status','pending')
            ->where('is_removed',0)
            ->whereRaw("TIMESTAMPDIFF(MINUTE,created_at,'{$now}') = 21")
            ->get();
    }

    public function removedPendingNudgesOnAccept($users, $currentNudge)
    {
        return $this->model->where('status', 'pending')
                        ->where('id','<>', $currentNudge)
                        ->whereRaw("(to_user_uuid in ('{$users[0]}','{$users[1]}')
                                or  from_user_uuid in ('{$users[0]}','{$users[1]}'))")
                        ->where('is_expired', 0)
                        ->update(['is_removed' => 1]);
    }

    public function getExpiredNudges()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return $this->model
            ->where('is_expired', 0)
            ->whereRaw("IF(status = 'pending', TIMESTAMPDIFF(MINUTE,created_at,'{$now}'), TIMESTAMPDIFF(MINUTE,updated_at,'{$now}')) > 20")
            ->update(['is_expired' => 1]);
    }
}
