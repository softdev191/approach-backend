<?php


use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class SNSTest extends \Tests\TestCase
{
     use DatabaseTransactions;

    public function testAddDeviceError422()
    {
        $user = factory(\App\Models\User::class)->make();
        $user->save();

        $response = $this->post("api/add-device",[

        ], $this->getHeader($user));
        $response->assertStatus(422);
    }
    public function testAddDeviceSuccessful()
    {
        $user = factory(\App\Models\User::class)->make();
        $user->save();

        // TEST 200
        $response = $this->post("api/add-device",[
            'device_token' => uniqid(),
            'platform' => 'ios'
        ],  $this->getHeader($user));
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

}
