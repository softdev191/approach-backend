# User mobile or email exist

**URL** : `http://approach.aleliepangilinan.xyz/api/user/exist`

**Method** : `POST`

**Parameter**
```json
{
    "mobile"         : "Required if email and token is null",
    "email"          : "Required if mobile and token is null",
    "token"          : "Required if email and mobile is null (used only for apple sign in)"
}
```

## Success Response
**Code**: `200`

**Response**
```json
{
    "message" : "String",
    "exist"   : "Boolean"
}
```

## Parameter Error Response
**Code** : `422`

**Response**
```json
{
    "mobile"                : [],
    "email"                : []
}
```
