<?php


namespace App\Http\Controllers;


use App\Service\StoreService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    protected $service;

    protected $request;

    /**
     * StoreController constructor.
     */
    public function __construct(Request $request, StoreService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    public function storeNearby()
    {
        $validator = Validator::make($this->request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->storeNearby();
        return response()->json(['message' => $response->message, 'stores' => $response->stores], $response->status);
    }

}
