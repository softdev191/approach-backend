# Users nearby

**URL** : `http://approach.aleliepangilinan.xyz/api/store/nearby`

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
    "stores"   : [
      {
          "uuid": "String",
          "name": "String",
          "address": "String",
          "logo": "String",
          "lat": "String",
          "lng": "String",
          "distance": "Decimal"
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
