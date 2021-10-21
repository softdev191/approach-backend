<?php


namespace App\Service;


use App\AbstractBases\AbstractBaseService;
use App\Events\SendNotificationEvent;
use App\Http\Controllers\Controller;
use App\Repositories\DeviceTokenRepository;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class MessageService extends AbstractBaseService
{

    protected $repository;

    protected $request;

    protected $deviceTokenRepository;

    public function __construct(
        Request $request,
        MessageRepository $repository,
        DeviceTokenRepository $deviceTokenRepository
    )
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->deviceTokenRepository = $deviceTokenRepository;
    }

    public function send()
    {
        $data = $this->request->all();
        $data['uuid'] = Uuid::uuid4()->toString();
        $data['sender'] = authUser()->user->uuid;
        $send = $this->repository->send($data);

        if(!$send){
            $this->response = $this->makeResponse(400, 'messages.send400');
            return $this->response();
        }
        // GET ARN INFO OF RECEIVER
        $credentials = $this->deviceTokenRepository->getUserDevices($this->request->post('receiver'));

        if (!$credentials) {
            $this->response = $this->makeResponse(400, 'messages.send400');
            return $this->response();
        }

        $payload =[
            'uuid' => authUser()->user->uuid,
            'message' => ($this->request->post('attachment')) ? authUser()->user->first_name . " sent you an image" : $this->request->post('content')
        ];

        $this->sendEvent($credentials, 'You have a new message!', 'send-message', $payload);
        $this->response = $this->makeResponse(200, 'messages.send.200');
        return $this->response();
    }

    public function getMessages($page)
    {
        $messages = $this->repository->getMessages($page,$this->request->post('user'));

        if(!$messages){
            $this->response = $this->makeResponse(400, 'messages.retrieve.400');
            return $this->with(["data" => []])->response();
        }

        $this->response = $this->makeResponse(200, 'messages.retrieve.200');
        return $this->with((array)$messages)->response();
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
}
