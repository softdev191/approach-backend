# Send messages

**URL** : `http://approach.aleliepangilinan.xyz/api/message/send`

**Method** : `POST`

**Parameter**
```json
{
    "content"                  : "String [Optional]",
    "attachment"               : "Base64 [Optional]",
    "receiver"                 : "String [Required]"
}
```

## Success Response
**Code**: `200`

**Response**
```json
{
    "message": "Message retrieved",
   
}
```

## Parameter Error Response
**Code** : `422`

**Response**
```json
{
    "content"                  : [],
    "attachment"                  : [],
    "receiver"                  : []
}
```
