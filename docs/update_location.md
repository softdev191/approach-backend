# Update user location

**URL** : `http://approach.aleliepangilinan.xyz/api/user/update/location`

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
    "lat"                : "Decimal [Required if sender didn't suggest location]",
    "lng"                : "Decimal [Required if sender didn't suggest location]"
}
```

## Success Response
**Code**: `200`

**Response**
```json
{
    "message" : "String",
    "user"    : "Object"
}
```

## Parameter Error Response
**Code** : `422`

**Response**
```json
{
    "lat"                : [],
    "lng"                : []
}
```
