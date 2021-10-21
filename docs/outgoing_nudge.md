# Outgoing nudges

**URL** : `http://approach.aleliepangilinan.xyz/api/nudge/outgoing`

**Method** : `GET`

**Header Requirements**
```json
{
    "Authorization": "<JWT Token from Login>"
}
```

## Success Response
**Code**: `200`

**Response**
```json
{
    "message": "Outcoming nudges retrieved",
    "data": [
      {
        "from_user_uuid": "18352c4f-d695-415b-a879-f41d39904e68",
        "to_user_uuid": "fdb467c3-0eb8-4413-b47d-3722806b17eb",
        "type": "send-nudge",
        "location": "SB",
        "status": "accepted",
        "isActive": 1,
        "lat": "14.123333",
        "lng": "121.000990",
        "minute_from_request": "Integer",
        "time_remaining": "Integer",
        "user": {
            "uuid": "18352c4f-d695-415b-a879-f41d39904e68",
            "email": "apangilinan@yondu.com",
            "mobile": "9789678582",
            "first_name": "Moon",
            "birth_date": "1996-06-27",
            "photos": [
                "https://approach-dev.s3.ap-southeast-1.amazonaws.com/user/profile_images/1617268877.jpg"
            ],
            "gender": "Female",
            "height": "5 ft 6",
            "education": "bsit",
            "profession": "soft eng",
            "my_saturday": "naah",
            "ask_me": "test",
            "visibility": 1,
            "lat": "14.009998",
            "lng": "121.988890",
            "sign_in_via": "app"
        }
      }
    ]
}
```
