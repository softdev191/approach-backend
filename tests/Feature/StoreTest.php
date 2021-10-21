<?php


use Illuminate\Http\Response;

class StoreTest extends \Tests\TestCase
{
    public function testNoNearbyStore()
    {
        $user = factory(\App\Models\User::class)->make();
        $user->save();

        // TEST 404
        $response = $this->post("api/store/nearby",[
            'lat' => 1,
            'lng' => 12
        ],  $this->getHeader($user));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'stores'
        ]);
    }

    public function testNearbyStoreSuccess()
    {
        $user = factory(\App\Models\User::class)->make([
            'lat' => '15.168928',
            'lng' => '121.0105893'
        ]);
        $user->save();

        // TEST 200
        $response = $this->post("api/store/nearby",[
            'lat' => $user->lat,
            'lng' => $user->lng
        ],  $this->getHeader($user));
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'stores'
        ]);
    }
}
