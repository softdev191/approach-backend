# Retrieve messages

**URL** : `http://approach.aleliepangilinan.xyz/api/message/retrieve/{page}`

**Method** : `POST`

**Parameter**
```json
{
    "user"                  : "String [Required]"
}
```

## Success Response
**Code**: `200`

**Response**
```json
{
    "message": "Message retrieved",
    "status": 200,
    "list": [
        {
            "content": "test reply by me 2",
            "attachment": null,
            "sender": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "receiver": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "is_from_current_sender": 1,
            "created_at": "2021-07-08 12:36:19"
        },
        {
            "content": "test reply by me 2",
            "attachment": "https://approach-dev.s3.ap-southeast-1.amazonaws.com/message/attachments/1625747674305.x-empty",
            "sender": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "receiver": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "is_from_current_sender": 1,
            "created_at": "2021-07-08 12:34:34"
        },
        {
            "content": null,
            "attachment": "https://approach-dev.s3.ap-southeast-1.amazonaws.com/message/attachments/1625734788249.jpeg",
            "sender": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "receiver": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "is_from_current_sender": 1,
            "created_at": "2021-07-08 08:59:48"
        },
        {
            "content": null,
            "attachment": "https://approach-dev.s3.ap-southeast-1.amazonaws.com/message/attachments/1625733511854.jpg",
            "sender": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "receiver": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "is_from_current_sender": 1,
            "created_at": "2021-07-08 08:38:32"
        },
        {
            "content": null,
            "attachment": "https://approach-dev.s3.ap-southeast-1.amazonaws.com/message/attachments/1625733197882..jpg",
            "sender": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "receiver": "2d076b44-3b56-4e04-990d-6aeccdb152cd",
            "is_from_current_sender": 1,
            "created_at": "2021-07-08 08:33:17"
        }
    ],
        "max_page": 2,
        "prev_page": 0,
        "next_page": 1

}
```

## Parameter Error Response
**Code** : `422`

**Response**
```json
{
    "user"                  : []
}
```
