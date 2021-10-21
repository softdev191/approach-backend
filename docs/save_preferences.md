# Save/Update Preferences

**URL** : `http://approach.aleliepangilinan.xyz/api/user/preferences`

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
    "preferences"       : [
                             {
                                "attribute" : "String [Required] (gender,age_range,height)",
                                "value"     : "Array [Required]"
                             }     
                         ] 
       }
}
```
**Value parameter example**
```
//for gender
[
    2,3,4
]
// for height range
[
    "160-170"
]
// for age range
[
    "20-30"
]
```
## Success Response
**Code**: `200`

**Response**
```json
{
    "message": "String",
    "preferences": [
      {
            "user_uuid": "String",
            "attribute": "String",
            "value": "Array",
            "label": "String"
          }
    ]
}
```


## Parameter Error Response
**Code** : `422`

**Response**
```json
{
   "attribute" : "[]",
   "value" : "[]"
}
```
