<?php


namespace App\Http\Controllers;


use App\Service\MailService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    protected $service;

    protected $request;

    /**
     * UserController constructor.
     */
    public function __construct(Request $request, UserService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    public function getUser($user)
    {
        $response = $this->service->getUser($user);
        return response()->json(['message' => $response->message, 'user' => $response->user], $response->status);
    }
    public function usersNearby()
    {
        $validator = Validator::make($this->request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->usersNearby();
        return response()->json(['message' => $response->message, 'users' => $response->users], $response->status);
    }

    public function updateLocation()
    {
        $validator = Validator::make($this->request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->updateLocation();
        return response()->json(['message' => $response->message, 'user' => $response->user], $response->status);
    }

    public function updateVisibility()
    {
        $validator = Validator::make($this->request->all(), [
            'visibility' => "required|boolean",
            'lat' => 'required_if:visibility,1',
            'lng' => 'required_if:visibility,1'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->updateVisibility();
        return response()->json(['message' => $response->message, 'user' => $response->user], $response->status);
    }

    public function userExist()
    {
        $validator = Validator::make($this->request->all(), [
            'mobile' => 'required_without_all:token,email',
            'email' => 'required_without_all:token,mobile|email|nullable',
            'token' => 'required_without_all:mobile,email'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->userEmailMobileExist();
        return response()->json(['message' => $response->message, 'exist' => $response->data, 'name' => $response->name], $response->status);

    }

    public function genderMetas()
    {
        $response = $this->service->genderMetas();
        return response()->json(['message' => $response->message, 'gender' => $response->gender], $response->status);
    }

    public function updateProfile()
    {
        $response = $this->service->updateProfile();
        return response()->json(['message' => $response->message, 'user' => $response->user], $response->status);
    }

    public function getLookingForPreferences()
    {
        return response()->json(lookingForPreferences(), 200);
    }

    public function getPreferences()
    {
        $response = $this->service->getPreferences();
        return response()->json(['message' => $response->message, 'preferences' => $response->preferences], $response->status);
    }

    public function savePreferences()
    {
        $validator = Validator::make($this->request->all(), [
            'preferences' => "required|array",
            'preferences.*.attribute' => 'required|userPreferencesAttr',
            'preferences.*.value' => 'sometimes|max:100|array'
            ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->savePreferences();
        return response()->json(['message' => $response->message, 'preferences' => $response->preferences], $response->status);
    }

    public function getAttributes($type)
    {
        $response = $this->service->getAttributes($type);
        return response()->json(['message' => $response->message, 'attributes' => $response->attributes], $response->status);
    }

    public function blockUser()
    {
        $validator = Validator::make($this->request->all(), [
            'user_uuid' => "required"
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->blockUser();
        return response()->json(['message' => $response->message], $response->status);
    }

    public function forgotPassword()
    {
        $service = new MailService();

        dd($service->sendMail());
    }

}
