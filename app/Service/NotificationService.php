<?php


namespace App\Service;


use App\Events\SendNotificationEvent;
use App\Repositories\BlockedUserRepository;
use App\Repositories\DeviceTokenRepository;
use App\Repositories\NudgeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class NotificationService extends SnsService
{
    protected $nudgeRepository;

    protected $request;

    protected $deviceTokenRepository;

    protected $userRepository;

    protected $blockedUserRepository;

    public function __construct(Request $request,
                                DeviceTokenRepository $deviceTokenRepository,
                                NudgeRepository $nudgeRepository,
                                UserRepository $userRepository,
                                BlockedUserRepository $blockedUserRepository)
    {
        parent::__construct();
        $this->request = $request;
        $this->deviceTokenRepository = $deviceTokenRepository;
        $this->nudgeRepository = $nudgeRepository;
        $this->userRepository = $userRepository;
        $this->blockedUserRepository = $blockedUserRepository;
    }

    public function addDevice()
    {
        $arn = $this->generateArn();

        if(!$arn){
            $this->response = $this->makeResponse(400, 'add-device.400');
            return $this->response;
        }

        $data = array(
            'platform' => $this->request->platform,
            'device_token' => $this->request->device_token,
            'user_uuid' => authUser()->user->uuid,
            'arn' => $arn,
            'is_sandbox' => $this->request->is_sandbox
        );

        $credentials = $this->deviceTokenRepository->firstOrCreateDeviceToken($data);
        if(!$credentials){
            $this->response = $this->makeResponse(400, 'add-device.400');
            return $this->response;
        }

        $this->response = $this->makeResponse(200, 'add-device.200');
        return $this->response;
    }

    public function sendNudge()
    {
        $receiver = $this->request->post('user_uuid');

        $receiverInfo = $this->userRepository->find('uuid', $receiver);


        if(!$receiverInfo){
            $this->response = $this->makeResponse(200, 'user.404');
            return $this->response;
        }

        // GET ARN INFO OF RECEIVER
        $credentials = $this->deviceTokenRepository->getUserDevices($receiver);
        if (!$credentials) {
            $this->response = $this->makeResponse(400, 'send_nudge.receiver_no_credentials');
            return $this->response;
        }

        $data =[
            'from_user_uuid' => authUser()->user->uuid,
            'to_user_uuid' => $receiver,
            'location' => $this->request->post('location'),
            'lat' => $this->request->post('lat'),
            'lng' => $this->request->post('lng'),
            'type' => 'send-nudge',
            'status' =>'pending',
            'isActive' => 0,
            'is_removed' => 0,
            'is_expired' => 0,
            'is_incoming_nudge_request' => true
        ];

        $payload =[
            'uuid' => authUser()->user->uuid,
            'is_incoming_nudge_request' => true
        ];
        // CHECK IF THERE'S PENDING NUDGE
        $hasPendingNudge = $this->nudgeRepository->pendingNudge($data);
        if($hasPendingNudge){
            $this->response = $this->makeResponse(400, 'send_nudge.has_pending_nudge');
            return $this->response;
        }

        // Receiver has active nudge
        $receiverAcceptedNudge = $this->nudgeRepository->acceptedNudge($receiver);
        if($receiverAcceptedNudge){
            $this->response = $this->makeResponse(400, 'send_nudge.has_accepted_nudge', ['NAME' => $receiverInfo->first_name ]);
            return $this->response;
        }

        // Sender has active nudge
        $senderAcceptedNudge = $this->nudgeRepository->acceptedNudge(authUser()->user->uuid);
        if($senderAcceptedNudge){
            $this->response = $this->makeResponse(400, 'send_nudge.has_accepted_nudge', ['NAME' => 'you']);
            return $this->response;
        }

        $save = $this->nudgeRepository->create($data);

        if(!$save){
            $this->response = $this->makeResponse(200, 'send_nudge.error_encountered');
            return $this->response;
        }
        $this->sendEvent($credentials, 'Someone sent you a nudge!', 'send-nudge', $payload);

        $this->response = $this->makeResponse(200, 'send_nudge.success');
        return $this->response;
    }

    public function incomingNudges()
    {
        $nudges = $this->nudgeRepository->getIncomingNudges();

        if(!$nudges){
            $this->response = $this->makeResponse(400, 'incoming_nudges.404');
            return $this->with(['data' => []])->response();
        }

        $this->response = $this->makeResponse(200, 'incoming_nudges.200');
        return $this->with(['data' => $nudges])->response();
    }

    public function outgoingNudges()
    {
        $nudges = $this->nudgeRepository->getOutgoingNudges(authUser()->user->uuid);

        if(!$nudges){
            $this->response = $this->makeResponse(200, 'outgoing_nudges.200');
            return $this->with(['data' => []])->response();
        }

        $this->response = $this->makeResponse(200, 'outgoing_nudges.200');
        return $this->with(['data' => $nudges])->response();
    }

    public function acceptedNudges()
    {
        $nudges = $this->nudgeRepository->getAcceptedNudges(authUser()->user->uuid);

        if(!$nudges){
            $this->response = $this->makeResponse(200, 'accepted_nudges.200');
            return $this->with(['data' => []])->response();
        }

        $this->response = $this->makeResponse(200, 'accepted_nudges.200');
        return $this->with(['data' => $nudges])->response();
    }

    public function nudgeUpdateStatus()
    {
        $sender = $this->userRepository->find('uuid', $this->request->post('user_uuid'));

        if(!$sender) {
            $this->response = $this->makeResponse(200, 'user.404');
            return $this->response;
        }

        $name = ucwords(authUser()->user->first_name);
//        $outgoingNudge = $this->nudgeRepository->getOutgoingNudge(authUser()->user->uuid);
//
//        // CHECK IF THERE ACTIVE OUTGOING NUDGES AND STATUS IS ACCEPTED
//        if (count($outgoingNudge) > 0 && $this->request->post('status') == 'accepted') {
//            $this->response = $this->makeResponse(400, 'has_outgoing_nudge');
//            return $this->with(['data' => []])->response();
//        }

        // GET DEVICE CREDENTIAL SENDER
        $credentials = $this->deviceTokenRepository->getUserDevices($sender->uuid);

        if($this->request->post('status') == 'cancelled'){
            $nudge = $this->nudgeRepository->getNudgeFromUserToUserForCancel($this->request->post('user_uuid'));
        }else{
            $nudge = $this->nudgeRepository->getNudgeFromUserToUser($sender->uuid);
        }

        if(!$nudge){
            $this->response = $this->makeResponse(200, 'nudge.404');
            return $this->with([ 'data' => []])->response();
        }

        $title = "";
        switch ($this->request->post('status')) {
            case 'accepted':

                if(isset($this->request->location)){
                    $nudge->location = $this->request->post('location');
                    $nudge->lat = $this->request->post('lat');
                    $nudge->lng = $this->request->post('lng');
                }
                $title = "{$name} has accepted your nudge!";
                $nudge->isActive = 1;
                $this->response = $this->makeResponse(200, 'accepted_nudge');

                $credentialsReceiver = $this->deviceTokenRepository->getUserDevices(authUser()->user->uuid);
                $this->nudgeRepository->removedPendingNudgesOnAccept([$sender->uuid, authUser()->user->uuid], $nudge->id);
                $this->sendEvent($credentialsReceiver, 'You accepted a nudge!', 'send-nudge', ['uuid' => $sender->uuid, 'is_incoming_nudge_request' => false]);

                break;

            case 'rejected':

                $title =  "{$name} has rejected your nudge!";
                $this->response = $this->makeResponse(200, 'rejected_nudge', ['NAME' => $sender->first_name ]);
                break;

            case 'cancelled':

                if($nudge->minute_from_request > 20){
                    $this->response = $this->makeResponse(200, 'cancelled_nudge.time_exceeded', ['NAME' => $sender->first_name]);
                    return $this->with([ 'data' => []])->response();
                }
                $title = "{$name} has cancelled your nudge!";
                $nudge->isActive = 0;
                $this->response = $this->makeResponse(200, 'cancelled_nudge.success', ['NAME' => $sender->first_name ]);
                break;

            case 'blocked':

                $blocked = $this->blockedUserRepository->create([
                    'blocked_user_uuid' => $sender->uuid,
                    'blocked_by'    => authUser()->user->uuid
                ]);

                if($blocked){
                    $this->response = $this->makeResponse(200, 'blocked_nudge', ['NAME' => $sender->first_name ]);
                }
                $title = "{$name} has rejected your nudge!";
                break;
        }
        $nudge->status = $this->request->post('status');
        $nudge->save();

        if($credentials){
            $nudge->fresh();
            $payload =[
                'uuid' => authUser()->user->uuid,
                'is_incoming_nudge_request' => false,
                'location' => $nudge->location,
                'lat' => $nudge->lat,
                'lng' => $nudge->lng,
                'status' => $this->request->post('status')
            ];

            $this->sendEvent($credentials, $title, 'send-nudge', $payload);

        }

        return $this->with([
            'data' => [
                'location' => $nudge->location,
                'lat' => $nudge->lat,
                'lng' => $nudge->lng
            ]
        ])->response();
    }

    public function sendEvent($credentials, $title, $type, array $payload = [])
    {
        foreach ($credentials as $credential) {
            $data = [
                'id' => $credential->id,
                'platform' => $credential->platform,
                'arn' => $credential->arn,
                'user_uuid' => $credential->user_uuid,
                'title' => $title,
                'type' => $type,
                'payload' => $payload
            ];
            // SEND PUSH NOTIF
            event(new SendNotificationEvent($data));
        }
    }

    public function getFromUser($user)
    {
        $nudges = $this->nudgeRepository->getFromUser($user);

        if(!$nudges){
            $this->response = $this->makeResponse(200, 'incoming_nudges.200');
            return $this->with(['data' => []])->response();
        }

        $this->response = $this->makeResponse(200, 'incoming_nudges.200');
        return $this->with(['data' => $nudges])->response();
    }

    public function getToUser($user)
    {
        $nudges = $this->nudgeRepository->getToUser($user);

        if(!$nudges){
            $this->response = $this->makeResponse(200, 'incoming_nudges.200');
            return $this->with(['data' => []])->response();
        }

        $this->response = $this->makeResponse(200, 'incoming_nudges.200');
        return $this->with(['data' => $nudges])->response();
    }


}
