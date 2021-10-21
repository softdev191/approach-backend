# Save/Update Preferences

**URL** : `http://approach.aleliepangilinan.xyz/api/user/preferences/get`

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
    "message": "String",
    "preferences": [
              {
                "user_uuid": "f398f535-eff9-35ff-a98b-f0750eb5aff4",
                "attribute": "gender",
                "value_array": [2,3,4],
                "label": "I'm interested in"
              }
        ]
}
```
