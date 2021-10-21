<?php


namespace Tests\Feature;


use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testLoginEntityNotFound()
    {
        $response = $this->post("api/login",[]);
        $response->assertStatus(422);
    }

    public function testLoginSuccessful()
    {
        $user = factory(\App\Models\User::class)->make();
        $user->save();

        // TEST 200
        $response = $this->post("api/login",[
            'user' => $user->email ,
            'password' => 'password',
            'sign_in_via' => 'app',
            'token' => null,
            'platform' => 'ios'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'access_token'
        ]);
    }

    public function testLoginViaAppleSuccessful()
    {
        $user = factory(\App\Models\User::class)->make();
        $user->save();

        // TEST 200
        $response = $this->post("api/login",[
            'user' => null,
            'password' =>  null,
            'sign_in_via' => 'apple',
            'token' => 'eyJraWQiOiJZdXlYb1kiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLmFwcHJvYWNoZGF0aW5nLmFwcHJvYWNoIiwiZXhwIjoxNjIwOTYxOTY5LCJpYXQiOjE2MjA4NzU1NjksInN1YiI6IjAwMTc1MS45ZTQ0YWQzYTNkYTM0MjAxYmMwYmZjZTgwNmFjZDhiMi4wNDA4IiwiY19oYXNoIjoib0FCdkhSWEUzalZlQXFfc09OeDEzdyIsImVtYWlsIjoicGFuZ2lsaW5hbmFsZWxpZUBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6InRydWUiLCJhdXRoX3RpbWUiOjE2MjA4NzU1NjksIm5vbmNlX3N1cHBvcnRlZCI6dHJ1ZX0.nwPb8ASff62qf4GjRf4FL-f8pUEIpMYg1gAzAdL9fgwf_9f_zw56fmN8xOJBwOLQ3p3xBy3tDhlLDbp5amX44Fl-J2OOZCYlY0h9c12EYzG8GkZlgK1IBtESpberr_DhtQOjRUvka19v-P9q1oNa1amZpEfYXuW_LuRMGeN1HSlE__tiUsp9Z4OO-eYoEA0thWgEBYBTe7HTf_K71rlq7FunfbER5rRfGbxDn97gg23dJQnV6UANyC9vJ2-RMKzTXv1aDSBH-h8lso7Eu6J9juTLj9xeDgXTsIct6AsALD7MAczT-03PZ1qbPZ2Nr6HdPX5KbNnjkSFpESJxCl6UvQ',
            'platform' => 'ios'
        ]);
       //$this->debug($response);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'access_token'
        ]);
    }
}
