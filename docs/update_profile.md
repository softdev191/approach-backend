# Update User Profile

**URL** : `http://approach.aleliepangilinan.xyz/api/user/update/profile`

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
    "email"                  : "String [Optional without mobile]",
    "mobile"                 : "String [Optional without email]",
    "first_name"             : "String [Optional without token]",
    "photos"                 : "Array  [Optional] Multipart",
    "birth_date"             : "String [Optional] without token",
    "gender"                 : "Int [Optional]",
    "height"                 : "String [Optional]",
    "visibility"             : "String [Optional]",
    "info"                   : [ // Optional
                                 {
                                    "attribute" : "String [Required] (profession,ask_me,my_saturday)",
                                    "value"     : "String [Required]",
                                    "label"     : "String [Required]"
                                 }     
                             ] 
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
        "info"                   : [
                                      {
                                         "attribute" : "String [Required] (profession,ask_me,my_saturday)",
                                         "value"     : "String [Required]",
                                         "label"     : "String [Required]"
                                      }     
                                  ] 
    }
 
}

```
