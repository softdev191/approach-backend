# Add device

**URL** : `http://approach.aleliepangilinan.xyz/api/add-device`

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
    "device_token"          : "String [Required] ",
    "platform"              : "String [Required] (ios,android)",
    "is_sandbox"            : "Boolean [Required] (0 or 1)"
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
