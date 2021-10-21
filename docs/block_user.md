# Block user

**URL** : `http://approach.aleliepangilinan.xyz/api/user/block`

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
    "user_uuid"          : "String [Required]"
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
    "user_uuid"          : []
}
```
