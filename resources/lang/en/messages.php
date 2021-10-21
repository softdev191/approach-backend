<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we neapi/add-deviced to display to the user. You are free to modify
    | these language lines according to your application"s requirements.
    |
    */

    "register" => [
        "400" => "Sorry error encountered with the registration",
        "200" => "Registration successful",
        "social_error" => "Error authenticating token",
        "email_already_exists" => "Sorry email already exists",
        "mobile_already_exists" => "Sorry mobile number already exists",
    ],
    "login" => [
        "400" => "Sorry error encountered with the registration",
        "200" => "Registration successful",
        "social_error" => "Error authenticating token"
    ],
    "user" =>[
        "404" => "User not found",
        "200" => "Successfully retrieved user",
        "mobile_email" => [
            "200" => "Account already exist",
            "404" => "No account found"
        ],
        "nearby" => [
            "not_found" => "No nearby users found",
            "found" => "Users nearby found"
        ],
        "location" =>[
            "update_200" => "Location updated!",
            "update_400" => "Error updating user location"
        ],
        "visibility" =>[
            "update_200" => "Visibility updated!",
            "update_400" => "Error updating user visibility"
        ],
        "update_profile" => [
            "400" => "Error updating profile",
            "200" => "Sucessfully updated profile"
        ],
        "preference" => [
            "save" => [
                "200" => "Preferences saved",
                "400" => "Error saving preferences"
            ],
            "get" => [
                "200" => "Successfully retrieved preferences",
                "404" => "No preferences found"
            ]
        ],
        "attributes" => [
            "200" => "Successfully retrieved attributes",
            "404" => "No attributes found"
        ],
        "block" => [
            "400" => "Error encountered",
            "200" => ":NAME can no longer see you on the map"
        ]
    ],
    "add-device" =>[
        "200" => "Device Added",
        "404" => "SNS error encountered"
    ],
    "send_nudge" => [
        "has_pending_nudge" => "Sorry you still have pending nudge to this user",
        "has_accepted_nudge" => "Sorry :NAME already accepted a nudge",
        "error_encountered"  => "Error Encountered",
        "receiver_no_credentials"  => "Unable to send nudge to user device",
        "success" => "Nudge successfully sent!"
    ],
    "incoming_nudges" => [
            "200" => "Incoming nudges retrieved",
            "404" => "No incoming nudges found"
    ],
    "outgoing_nudges" => [
        "200" => "Outgoing nudges retrieved",
        "404" => "No outgoing nudges found"
    ],
    "accepted_nudges" => [
        "200" => "Accepted nudge retrieved",
        "404" => "No Accpeted nudge found"
    ],
    "nudge" => [
        '404' => "Nudge not found"
    ],
    "store" => [
        "nearby" => [
            "found" => "Nearby stores found",
            "not_found" => "No nearby stores found"
        ]
    ],
    "has_outgoing_nudge" => "Sorry you already have outgoing nudge",
    "accepted_nudge" => "Approach Confirmed! Have a great time",
    "rejected_nudge" => "Unfortunately, :NAME is unavailable to meet right now. Check out your radar to send another nudge!",
    "cancelled_nudge" => [
        "success" => "We will let :NAME know you are not able to meet.",
        "time_exceeded" => "Sorry you are only allowed to cancel nudges within 20 minutes",
    ],
    "blocked_nudge" => "Approach Denied! We will let :NAME know you are not available. :NAME can no longer see you on the map",
    "gender_retrieved" => "Gender retrieved",
    "messages" => [
        "send" => [
            "200" => "Message sent",
            "400" => "Error encountered sending the message"
        ],
        "retrieve" => [
            "200" => "Message retrieved",
            "400" => "Error retrieving the message"
        ]

    ]
];
