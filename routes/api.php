<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("/sender", function () {
    $message = \App\Models\Message::first();
    $message->channel = $message->from_id . "-". $message->to_id;
    event(new \App\Events\MessageSent($message->getAttributes()));

});

Route::post("register", "AuthController@register");
Route::post("login", [ "as" => "login", "uses" => "AuthController@authenticate"])->middleware(["throttle:10,1,login"]);
Route::post("user/exist", [ "as" => "user.exist", "uses" => "UserController@userExist"]);
Route::get("gender-metas", [ "as" => "gender", "uses" => "UserController@genderMetas"]);
Route::get("attributes/{type}", [ "as" => "attribute", "uses" => "UserController@getAttributes"]);
Route::get("preferences/looking-for", [ "as" => "preferences.looking_for", "uses" => "UserController@getLookingForPreferences"]);
Route::post("forgot-password", "UserController@forgotPassword");

Route::get("success", function (){
    echo "success";
});

Route::group(["middleware" => ["api.auth"]], function() {

    Route::post("add-device", "NotificationController@getDeviceToken");

    Route::group(["prefix" => "user", "middleware" => ["throttle:120,1,user"]], function(){
        Route::get("/", "AuthController@getAuthenticatedUser");
        Route::get("/from_user", "UserController@getFromUser");
        Route::get("/{uuid}", "UserController@getUser");
        Route::post("nearby", "UserController@usersNearby");
        Route::post("update/location", "UserController@updateLocation");
        Route::post("update/visibility", "UserController@updateVisibility");
        Route::post("update/profile", "UserController@updateProfile");
        Route::get("preferences/get", "UserController@getPreferences");
        Route::post("preferences", "UserController@savePreferences");
        Route::post("block", "UserController@blockUser");
    });

    Route::group(["prefix" => "nudge", "middleware" => ["throttle:120,1,nudge"]], function(){
        Route::post("send", "NotificationController@sendNudge");
        Route::get("incoming", "NotificationController@incomingNudges");
        Route::get("outgoing", "NotificationController@outgoingNudges");
        Route::get("accepted", "NotificationController@acceptedNudges");
        Route::post("update/status", "NotificationController@updateNudgeStatus");
        Route::get("from-user/{uuid}", "NotificationController@getFromUser");
        Route::get("to-user/{uuid}", "NotificationController@getToUser");
    });

    Route::group(["prefix" => "store"], function(){
        Route::post("nearby", "StoreController@storeNearby");
    });

    Route::group(["prefix" => "message","middleware" => ["throttle:120,1,message"]], function(){
        Route::post("retrieve/{page}", "MessageController@getMessages");
        Route::post("send", "MessageController@send");

    });

});
