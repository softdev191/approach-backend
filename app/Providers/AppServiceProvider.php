<?php

namespace App\Providers;

use App\Models\Attribute;
use App\Models\Nudge;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('locationRule', function ($attribute, $value, $parameters, $validator) {
            $request = app('request');

            $nudge = Nudge::where('from_user_uuid', $request->post('user_uuid'))
                ->orWhere('to_user_uuid', $request->post('user_uuid'))
                ->where('to_user_uuid', authUser()->user->uuid)->first();

            if(!$nudge->location && $request->status == "accepted" && $request->location == null){
                return false;
            }

            return true;
        });

        Validator::extend('updateEmail', function ($attribute, $value, $parameters, $validator) {
            $request = app('request');

            $email = User::where('email', $request->email)
                        ->where('uuid', '<>', authUser()->user->uuid)
                        ->count();
            if($email > 0){
                return false;
            }

            return true;
        });

        Validator::extend('updateMobile', function ($attribute, $value, $parameters, $validator) {
            $request = app('request');

            $email = User::where('mobile', $request->mobile)
                ->where('uuid', '<>',authUser()->user->uuid)
                ->count();

            if($email > 0){
                return false;
            }

            return true;
        });

        Validator::extend('userInfoAttr', function ($attribute, $value, $parameters, $validator) {
            $request = app('request');
            $allowedAttr = Attribute::where('type', 'user_info')->pluck('key');
            if(!in_array($value, $allowedAttr->toArray())){
                return false;
            }

            return true;
        });

        Validator::extend('userPreferencesAttr', function ($attribute, $value, $parameters, $validator) {
            $request = app('request');
            $allowedAttr = Attribute::where('type', 'preferences')->pluck('key');
            if(!in_array($value, $allowedAttr->toArray())){
                return false;
            }

            return true;
        });

        Validator::extend('validateName', function($attribute, $value)
        {
            return preg_match("/^[a-zA-ZÑñ\s.'-]*$/", $value);
        });

        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {

            if($value){
                $image = base64_decode($value);
                $f = finfo_open();
                $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
                return str_contains($result, 'image/');
            }

        });
    }
}
