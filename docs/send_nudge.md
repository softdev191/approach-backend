# Send Nudge

**URL** : `http://approach.aleliepangilinan.xyz/api/nudge/send`

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
    "receiver"          : "String [Required] user uuid",
    "location"          : "String [Required]",
    "lat"               : "Decimal [Required]",
    "lng"               : "Decimal [Required]"
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
    "device_token"          : [],
    "platform"              : []
  
}
```
