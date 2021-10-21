<?php

use Tymon\JWTAuth\Facades\JWTAuth;

if (! function_exists('authUser')) {
    function authUser() {
        $token = JWTAuth::getToken();
        $token = JWTAuth::getPayload($token)->toArray();

        return (object) $token;
    }
}

if (! function_exists('lookingForPreferences')) {
    function lookingForPreferences() {
        return [
            1 => "A Relationship",
            2 => "A Casual Conversation",
            3 => "Something Physical"
        ];
    }
}

if (! function_exists('getBase64FileType')) {
    function getBase64FileType($image) {
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
        $split = explode('/', $mime_type);
        $type = $split[1];

        return $type;
    }
}


