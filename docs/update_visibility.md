# Update User visibility

**URL** : `http://approach.aleliepangilinan.xyz/api/user/update/visibility`

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
    "visibility"         : "Boolean [Required]",
    "lat"                : "Decimal [Required if visibility is on]",
    "lng"                : "Decimal [Required if visibility is on]"
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
