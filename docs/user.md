# Get User Profile

**URL** : `http://approach.aleliepangilinan.xyz/api/user`

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
    "user": {
        "email"                  : "String",
        "mobile"                 : "String",
        "first_name"             : "String",
        "photos"                 : "Array",
        "birth_date"             : "String",
        "gender"                 : "Int",
        "height"                 : "String",
        "visibility"             : "String",
        "lat"                    : "Decimal",
        "lng"                    : "Decimal",
        "sign_in_via"            : "String",
        "age"                    : "Integer",
        "info": [
                   {
                         "user_uuid": "String",
                         "attribute": "String",
                         "value": "String",
                         "label": "String"
                       }   
                 ]
    }
 
}

```
