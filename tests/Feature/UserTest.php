<?php


use Illuminate\Http\Response;

class UserTest extends \Tests\TestCase
{
    public function testRegisterEntityNotFound()
    {
        $response = $this->post("api/register",[]);
        $response->assertStatus(422);
    }

    public function testRegisterViaAppSuccessful()
    {
        $user = factory(\App\Models\User::class)->make();

        // TEST 200
        $response = $this->post("api/register",[
            'email' => $user->email ,
            'mobile' => $user->mobile ,
            'password' => 'password' ,
            'first_name' => $user->first_name ,
            'birth_date' => $user->birth_date ,
            'photos' => [\Illuminate\Http\UploadedFile::fake()->create('test.jpg',2622)],
            'gender' => $user->gender ,
            'height' => $user->height ,
            'visibility' => $user->visibility ,
            'lat' => $user->lat ,
            'lng' => $user-> lng,
            'sign_in_via' => 'app',
            'platform' => 'ios',
            'token' => null,
            'info' => [
                ["attribute" => "my_saturday","value"  => "Netflix and Chill"],
                ["attribute" => "profession","value"  => "Tambay"],
                ["attribute" => "ask_me","value"  => "Life"],
            ]
        ]);
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'access_token'
        ]);
    }

    public function testRegisterViaAppleSuccessful()
    {
        $user = factory(\App\Models\User::class)->make();

        // TEST 200
        $response = $this->post("api/register",[
            'first_name' => $user->first_name ,
            'birth_date' => $user->birth_date ,
            'photos' => [\Illuminate\Http\UploadedFile::fake()->create('test.jpg',2622)],
            'gender' => $user->gender ,
            'height' => $user->height ,
            'visibility' => $user->visibility ,
            'lat' => $user->lat ,
            'lng' => $user-> lng,
            'sign_in_via' => 'apple',
            'platform' => 'ios',
            'token' => 'eyJraWQiOiJZdXlYb1kiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLmFwcHJvYWNoZGF0aW5nLmFwcHJvYWNoIiwiZXhwIjoxNjIzMTQ4MjEwLCJpYXQiOjE2MjMwNjE4MTAsInN1YiI6IjAwMTg5MS5mODc0OWRhYmU3N2Q0ZWIwOTNhODQ5NTdhZDkzNTZiYS4xMzMxIiwiY19oYXNoIjoicVNGSHdVakRBR3ZUU2V3UEFPZV9rZyIsImVtYWlsIjoiay5hLm1hbG9sZXNAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOiJ0cnVlIiwiYXV0aF90aW1lIjoxNjIzMDYxODEwLCJub25jZV9zdXBwb3J0ZWQiOnRydWV9.JbVKnWaB4zs9ZM0rT2bUnsH04xWiQ1tLCxIveOs_RjuVtHo9eyHmB6oOF8uCsxY78wXmVADFO9toBt_Lu_3ip0AVwVrVuU9X9Ivia28SzMQEB6RTFgVPwgyt9PuPSaTz87OEhC1k1bjewkBNa1lZEEA73Gpkr2lqGfDWI_3anJtaTVbNno7l1uWDAVxpcoAPM9sl--AUptrhG8PjpP92npVoeHduBPabLiq2rBcezWL3ULEtNVBl4GpRPFLuU9gAdBTZkNxi-jMIBoB3YN7IqRLqh6Uia40MYYeu7CCafYbx_AVbhF47X0cdIRWPo85nVUegXGRg47kk_QfbniDfFg',
            'info' => [
                ["attribute" => "my_saturday","value"  => "Netflix and Chill"],
                ["attribute" => "profession","value"  => "Tambay"],
                ["attribute" => "ask_me","value"  => "Life"],
            ]
        ]);
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'access_token'
        ]);
    }

    public function testRegisterViaFbSuccessful()
    {
        $user = factory(\App\Models\User::class)->make();

        // TEST 200
        $response = $this->post("api/register",[
            'birth_date' => $user->birth_date ,
            'photos' => [\Illuminate\Http\UploadedFile::fake()->create('test.jpg',2622)],
            'gender' => $user->gender ,
            'height' => $user->height ,
            'visibility' => $user->visibility ,
            'lat' => $user->lat ,
            'lng' => $user-> lng,
            'sign_in_via' => 'fb',
            'platform' => 'ios',
            'token' => 'EAAGVORWFnCIBAPgufyNxqy1U8kx7rONhqi6GxHZBfkPTFMhe7SUClj3OanaRQ0yWBO6lZAyOOKo62kglr4sSABxedkUozexVLlXjthri0arfZAyc3sglKBGhDCcKq8oBUU01QgAzWF7b3whkr9a1lv53olzqVuZCpnwOztUSrN7Vb8iAA21oNWDhJtOEJsZCSO4agH23lPXKrgSqTfHdDzyLZBFMncHUlHapvZCLRZBDuPi2QGuorgIS',
            'info' => [
                ["attribute" => "my_saturday","value"  => "Netflix and Chill"],
                ["attribute" => "profession","value"  => "Tambay"],
                ["attribute" => "ask_me","value"  => "Life"],
            ]
        ]);
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'access_token'
        ]);
    }

    public function testUpdateProfileEntityNotFound()
    {
        $user = factory(\App\Models\User::class)->create();
        $response = $this->post("api/user/update/profile",[],$this->getHeader($user));
        $response->assertStatus(422);
    }

    public function testUpdateProfileSuccess()
    {
        $user = factory(\App\Models\User::class)->create();
        //$user = \App\Models\User::where('uuid', '02e883eb-e79a-472b-8c45-e057ad18bdd1')->first();
        $userInfo = factory(\App\Models\UserInfo::class)->create([
            'user_uuid' => $user->uuid
        ]);

        // TEST 200
        $response = $this->post("api/user/update/profile",[
            'email' => $user->email ,
            'mobile' => $user->mobile ,
            'password' => 'password' ,
            'password_confirmation' => 'password' ,
            'first_name' => $user->first_name ,
            'birth_date' => $user->birth_date ,
            'photos' => [\Illuminate\Http\UploadedFile::fake()->create('test.jpg',2622)],
            'gender' => $user->gender ,
            'height' => $user->height ,
            'visibility' => $user->visibility ,
            'lat' => $user->lat ,
            'lng' => $user-> lng,
            'sign_in_via' => 'app',
            'token' => null,
            'info' => [
                ["attribute" => "my_saturday","value"  => "Netflix anf Chill update 1"],
                ["attribute" => "profession","value"  => "Tambay update 1"],
                ["attribute" => "ask_me","value"  => "Life update 1"],
            ]
        ], $this->getHeader($user));
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    public function testGetProfile()
    {
        $user = factory(\App\Models\User::class)->create();
        //$user = \App\Models\User::where('uuid', '4b8823fc-c86c-4118-9a93-43e5e4abbc5b')->first();

        $userInfo = factory(\App\Models\UserInfo::class)->create([
            'user_uuid' => $user->uuid
        ]);

        // TEST 200
        $response = $this->get("api/user", $this->getHeader($user));
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'user'
        ]);
    }

    public function testNearbyUsersEntityNotFound()
    {
        $response = $this->post("api/user/nearby",[], $this->getHeader());
        $response->assertStatus(422);
    }

    public function testNoNearbyUser()
    {
        $user = factory(\App\Models\User::class)->make();
        $user->save();

        // TEST 404
        $response = $this->post("api/user/nearby",[
            'lat' => 1,
            'lng' => 12
        ],  $this->getHeader($user));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'users'
        ]);
    }

    public function testNearbyUserSuccess()
    {
        $user = factory(\App\Models\User::class)->make([
            'lat' => '15.168928',
            'lng' => '121.0105893'
        ]);
        $user->save();

        $user1 = factory(\App\Models\User::class)->create([
            'lat' => '15.1663627',
            'lng' => '121.0296115'
        ]);
        $user1->save();

        // TEST 200
        $response = $this->post("api/user/nearby",[
            'lat' => $user->lat,
            'lng' => $user->lng
        ],  $this->getHeader($user));
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'users'
        ]);
    }

    public function testSavePreferencesSuccess()
    {
        $user = factory(\App\Models\User::class)->create();
//        $user = \App\Models\User::where('uuid', '47de8aed-7ea2-3055-95bd-a4a9f6d092a0')->first();
        $userInfo = factory(\App\Models\UserInfo::class)->create([
            'user_uuid' => $user->uuid
        ]);

        // TEST 200
        $response = $this->post("api/user/preferences",[
            'preferences' => [
                ["attribute" => "gender","value"  => [2,3,4] ],
                ["attribute" => "age_range","value"  => ["20-30"]],
                ["attribute" => "height","value"  => ["160-180"]],
            ]
        ], $this->getHeader($user));
        //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    public function testGetPreferences()
    {
        $user = factory(\App\Models\User::class)->create();
        $user = \App\Models\User::where('uuid', 'a683271e-0078-4421-947f-0febc24d9bf1')->first();
//        $userInfo = factory(\App\Models\UserInfo::class)->create([
//            'user_uuid' => $user->uuid
//        ]);
//
//        $userPreferences = factory(\App\Models\Preference::class)->create([
//            'user_uuid' => $user->uuid
//        ]);
        // TEST 200
        $response = $this->get("api/user/preferences/get", $this->getHeader($user));
        $this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    public function testGetAttributes()
    {
        // TEST 200
        $response = $this->get("api/attributes/user_info");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    public function testBlockUser()
    {
        $user = factory(\App\Models\User::class)->create();
//        $user = \App\Models\User::where('uuid', '47de8aed-7ea2-3055-95bd-a4a9f6d092a0')->first();
        $userInfo = factory(\App\Models\UserInfo::class)->create([
            'user_uuid' => $user->uuid
        ]);

        $userToBlock = factory(\App\Models\User::class)->create();
//        $user = \App\Models\User::where('uuid', '47de8aed-7ea2-3055-95bd-a4a9f6d092a0')->first();
        $userToBlockInfo = factory(\App\Models\UserInfo::class)->create([
            'user_uuid' => $userToBlock->uuid
        ]);

        // TEST 200
        $response = $this->post("api/user/block",[
           'user_uuid' => $userToBlock->uuid
        ], $this->getHeader($user));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    public function testUserExistEntityNotFound()
    {
        $response = $this->post("api/user/exist",[
            'mobile' => null,
            'email' => null,
            'token' => null
        ]);
        $response->assertStatus(422);
    }

    public function testUserExistSuccess()
    {
        $user = factory(\App\Models\User::class)->make();
        $user->save();

        $response = $this->post("api/user/exist",[
            'mobile' => $user->mobile,
            'email' => null,
            'token' => null
            //'token' => 'eyJraWQiOiJZdXlYb1kiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLmFwcHJvYWNoZGF0aW5nLmFwcHJvYWNoIiwiZXhwIjoxNjIzMTQ4MjEwLCJpYXQiOjE2MjMwNjE4MTAsInN1YiI6IjAwMTg5MS5mODc0OWRhYmU3N2Q0ZWIwOTNhODQ5NTdhZDkzNTZiYS4xMzMxIiwiY19oYXNoIjoicVNGSHdVakRBR3ZUU2V3UEFPZV9rZyIsImVtYWlsIjoiay5hLm1hbG9sZXNAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOiJ0cnVlIiwiYXV0aF90aW1lIjoxNjIzMDYxODEwLCJub25jZV9zdXBwb3J0ZWQiOnRydWV9.JbVKnWaB4zs9ZM0rT2bUnsH04xWiQ1tLCxIveOs_RjuVtHo9eyHmB6oOF8uCsxY78wXmVADFO9toBt_Lu_3ip0AVwVrVuU9X9Ivia28SzMQEB6RTFgVPwgyt9PuPSaTz87OEhC1k1bjewkBNa1lZEEA73Gpkr2lqGfDWI_3anJtaTVbNno7l1uWDAVxpcoAPM9sl--AUptrhG8PjpP92npVoeHduBPabLiq2rBcezWL3ULEtNVBl4GpRPFLuU9gAdBTZkNxi-jMIBoB3YN7IqRLqh6Uia40MYYeu7CCafYbx_AVbhF47X0cdIRWPo85nVUegXGRg47kk_QfbniDfFg'
        ]);
        //$this->debug($response);
        $response->assertStatus(200);
    }

    public function testGetUserInfo()
    {
        dd(base64_encode(file_get_contents(storage_path('test/jpeg.jpg'))));
        $user = factory(\App\Models\User::class)->make();
        $user->save();

        $userInfo = factory(\App\Models\UserInfo::class)->create([
            'user_uuid' => $user->uuid
        ]);
        // TEST 200
        $response = $this->get("api/user/{$user->uuid}", $this->getHeader($user));
        $this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'access_token'
        ]);
    }
}
