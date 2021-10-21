# Update Nudge Status

**URL** : `http://approach.aleliepangilinan.xyz/api/nudge/update/status`

**Method** : `POST`

**Header Requirements**
```json
{
    "Authorization": "<JWT Token from Login>"
}
```

**Parameter**
```json
{
    "user_uuid"          : "String  [Required] From/Senders Uuid",
    "status"             : "String  [Required] Accepted values (accepted,rejected,cancelled,blocked)",
    "location"           : "String  [Required if sender didn't suggest location]",
    "lat"                : "Decimal [Required if sender didn't suggest location]",
    "lng"                : "Decimal [Required if sender didn't suggest location]"
}
```

## Success Response
**Code**: `200`

**Response**
```json
{
    "message" : "String"
}
```

## Parameter Error Response
**Code** : `422`

**Response**
```json
{
    "user_uuid"          : [],
    "status"             : [],
    "location"           : [],
    "lat"                : [],
    "lng"                : []
}
```
