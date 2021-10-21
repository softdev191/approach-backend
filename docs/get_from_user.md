# Get From user info (nudge)

**URL** : `http://approach.aleliepangilinan.xyz/api/nudge/from-user/{uuid}`

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
    "message": "Incoming nudges retrieved",
    "data": [
        {
            "from_user_uuid": "fdb467c3-0eb8-4413-b47d-3722806b17eb",
            "to_user_uuid": "18352c4f-d695-415b-a879-f41d39904e68",
            "type": "send-nudge",
            "location": null,
            "status": "pending",
            "isActive": 0,
            "lat": null,
            "lng": null,
            "user": {
                "uuid": "fdb467c3-0eb8-4413-b47d-3722806b17eb",
                "email": "test@test.com",
                "mobile": "9789678581",
                "first_name": "alie",
                "birth_date": "1996-06-27",
                "photos": [
                    "https://approach-dev.s3.ap-southeast-1.amazonaws.com/user/profile_images/1617269737.jpg"
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
