# Users nearby

**URL** : `http://approach.aleliepangilinan.xyz/api/user/nearby`

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
    "lat"              : "Decimal [Required]",
    "lng"              : "Decimal [Required]"
}
```

## Success Response
**Code**: `200`

**Response**
```json
{
    "message" : "String",
    "users"   : [
      {
          "uuid": "String",
          "email": "String",
          "mobile": "String",
          "first_name": "String",
          "birth_date": "String",
          "photos": "String",
          "gender": "String",
          "height": "String",
          "education": "String",
          "profession": "String",
          "my_saturday": "String",
          "ask_me": "String",
          "visibility": "Integer",
          "lat": "String",
          "lng": "String",
          "sign_in_via": "String",
          "distance": "Integer"
      }    
    ]
}
```

## Parameter Error Response
**Code** : `422`

**Response**
```json
{
    "lat"                  : [],
    "lng"              : []
  
}
```
