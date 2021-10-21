<?php


namespace App\Http\Controllers;


use App\Service\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{

    protected $request;

    protected $service;

    public function __construct(Request $request, MessageService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    public function send()
    {
        $validator = Validator::make($this->request->all(), [
            'content' => 'required_without:attachment',
            'attachment' => 'required_without:content|base64image|nullable',
            'receiver' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->send();
        return response()->json(['message' => $response->message], $response->status);

    }

    public function getMessages($page)
    {
        $validator = Validator::make($this->request->all(), [
            'user' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $response = $this->service->getMessages($page);
        return response()->json( $response, $response->status);

    }
}
