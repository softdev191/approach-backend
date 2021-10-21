<?php


namespace App\Http\Controllers;

use App\Service\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    protected $service;

    protected $request;

    public function __construct(Request $request, NotificationService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    public function getDeviceToken()
    {
        $validator = Validator::make($this->request->all(), [
            'device_token' => 'required',
            'platform' => 'required|in:android,ios'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->addDevice();
        return response()->json(['message' => $response->message], $response->status);
    }

    public function sendNudge()
    {
        $validator = Validator::make($this->request->all(), [
            'user_uuid' => 'required',
            'location' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->sendNudge();
        return response()->json(['message' => $response->message], $response->status);
    }

    public function incomingNudges()
    {
        $response = $this->service->incomingNudges();
        return response()->json(['message' => $response->message, 'data' => $response->data],
                $response->status);
    }

    public function outgoingNudges()
    {
        $response = $this->service->outgoingNudges();
        return response()->json(['message' => $response->message, 'data' => $response->data],
            $response->status);
    }

    public function acceptedNudges()
    {
        $response = $this->service->acceptedNudges();
        return response()->json(['message' => $response->message, 'data' => $response->data],
            $response->status);
    }

    public function updateNudgeStatus()
    {
        $validator = Validator::make($this->request->all(), [
            'user_uuid' => 'required',
            'status' => 'required|in:accepted,rejected,cancelled,blocked'
//            'location' => 'locationRule',
//            'lat' => 'required_if:location,true',
//            'lng' => 'required_if:location,true',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->nudgeUpdateStatus();
        return response()->json(['message' => $response->message, 'data' => $response->data],
            $response->status);
    }

    public function getFromUser($user)
    {
        $response = $this->service->getFromUser($user);
        return response()->json(['message' => $response->message, 'data' => $response->data],
            $response->status);
    }

    public function getToUser($user)
    {
        $response = $this->service->getToUser($user);
        return response()->json(['message' => $response->message, 'data' => $response->data],
            $response->status);
    }

}
