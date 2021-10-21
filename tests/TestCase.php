<?php

namespace Tests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public function getHeader($user = null)
    {
        if(!$user){
            $user = factory(\App\Models\User::class)->make();
            $user->save();
        }

        $token = JWTAuth::fromUser($user);
        return ['Authorization' => 'Bearer ' . $token];
    }

    //for debugging
    public function debug($response, $flag = false) {
        $string = $response->baseResponse->getContent();
        if ($flag) {
            $string = preg_replace('/\s+/', ' ', trim($response->baseResponse->getContent()));
        }

        dd($string);
    }

    public function decode($response) {
        return json_decode($response->baseResponse->getContent());
    }
}
