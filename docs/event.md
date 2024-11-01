# Event API Spec

## GET Event API

Endpoint : GET/api/event

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": [
        {
            "id": "1",
            "user_id": "1",
            "title": "title",
            "deskripsi": "deskripsi",
            "image": "image",
            "status": "ongoing",
            "day": "day",
            "time": "time",
            "duration": "duration",
            "location": "location",
            "contact": "contact",
            "maps": "maps", //optional
            "event_category_id": "1",
            "documentation": [
                {
                    "id": "1",
                    "event_id": "1",
                    "image": "image",
                    "information": "information",
                    "created_at": "2024-10-29T11:01:17.000000Z",
                    "updated_at": "2024-10-29T11:01:17.000000Z"
                },
                {
                    "id": "1",
                    "event_id": "1",
                    "image": "image",
                    "information": "information",
                    "created_at": "2024-10-29T11:01:17.000000Z",
                    "updated_at": "2024-10-29T11:01:17.000000Z"
                }
            ],
            "ticket": {
                "id": "1",
                "event_id": "1",
                "stok": "300",
                "price": "10000",
                "image": "image",
                "payment_method": "bca:number",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            },
            "feedback": [
                {
                    "id": "1",
                    "event_id": "1",
                    "user_id": "1",
                    "comment": "comment",
                    "rating": "5",
                    "created_at": "2024-10-29T11:01:17.000000Z",
                    "updated_at": "2024-10-29T11:01:17.000000Z"
                },
                {
                    "id": "1",
                    "event_id": "1",
                    "user_id": "1",
                    "comment": "comment",
                    "rating": "5",
                    "created_at": "2024-10-29T11:01:17.000000Z",
                    "updated_at": "2024-10-29T11:01:17.000000Z"
                }
            ],
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        },
        {
            "id": "1",
            "user_id": "1",
            "title": "title",
            "deskripsi": "deskripsi",
            "image": "image",
            "status": "ongoing",
            "day": "day",
            "time": "time",
            "duration": "duration",
            "location": "location",
            "contact": "contact",
            "maps": "maps", //optional
            "event_category_id": "1",
            "documentation": [
                {
                    "id": "1",
                    "event_id": "1",
                    "image": "image",
                    "information": "information",
                    "created_at": "2024-10-29T11:01:17.000000Z",
                    "updated_at": "2024-10-29T11:01:17.000000Z"
                },
                {
                    "id": "1",
                    "event_id": "1",
                    "image": "image",
                    "information": "information",
                    "created_at": "2024-10-29T11:01:17.000000Z",
                    "updated_at": "2024-10-29T11:01:17.000000Z"
                }
            ],
            "ticket": {
                "id": "1",
                "event_id": "1",
                "stok": "300",
                "price": "10000",
                "image": "image",
                "payment_method": "bca:number",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            },
            "feedback": [
                {
                    "id": "1",
                    "event_id": "1",
                    "user_id": "1",
                    "comment": "comment",
                    "rating": "5",
                    "created_at": "2024-10-29T11:01:17.000000Z",
                    "updated_at": "2024-10-29T11:01:17.000000Z"
                },
                {
                    "id": "1",
                    "event_id": "1",
                    "user_id": "1",
                    "comment": "comment",
                    "rating": "5",
                    "created_at": "2024-10-29T11:01:17.000000Z",
                    "updated_at": "2024-10-29T11:01:17.000000Z"
                }
            ],
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        }
    ]
}
```

Response Body Erorr :

```json
{
    "errors": "data event not found"
}
```

## GET Event API

Endpoint : GET/api/event/:id

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": {
        "id": "1",
        "user_id": "1",
        "title": "title",
        "deskripsi": "deskripsi",
        "image": "image",
        "status": "ongoing",
        "day": "day",
        "time": "time",
        "duration": "duration",
        "location": "location",
        "contact": "contact",
        "maps": "maps", //optional
        "event_category_id": "1",
        "documentation": [
            {
                "id": "1",
                "event_id": "1",
                "image": "image",
                "information": "information",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            },
            {
                "id": "1",
                "event_id": "1",
                "image": "image",
                "information": "information",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            }
        ],
        "ticket": {
            "id": "1",
            "event_id": "1",
            "stok": "300",
            "price": "10000",
            "image": "image",
            "payment_method": "bca:number",
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        },
        "feedback": [
            {
                "id": "1",
                "event_id": "1",
                "user_id": "1",
                "comment": "comment",
                "rating": "5",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            },
            {
                "id": "1",
                "event_id": "1",
                "user_id": "1",
                "comment": "comment",
                "rating": "5",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            }
        ],
        "created_at": "2024-10-29T11:01:17.000000Z",
        "updated_at": "2024-10-29T11:01:17.000000Z"
    }
}
```

Response Body Erorr :

```json
{
    "errors": "data event not found"
}
```

## POST Event API

Endpoint : POST/api/event

Headers :

-   Authorization : token

Request Body :

```json
{
    "user_id": "1",
    "title": "title",
    "deskripsi": "deskripsi",
    "image": "image",
    "status": "ongoing",
    "day": "day",
    "time": "time",
    "duration": "duration",
    "prize": "prize",
    "location": "location",
    "contact": "contact",
    "maps": "maps",
    "event_category_id": "1"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "Success create event",
    "data": {
        "id": "1",
        "user_id": "1",
        "title": "title",
        "deskripsi": "deskripsi",
        "image": "image",
        "status": "ongoing",
        "day": "day",
        "time": "time",
        "duration": "duration",
        "location": "location",
        "contact": "contact",
        "maps": "maps", //optional
        "event_category_id": "1",
        "documentation": [
            {
                "id": "1",
                "event_id": "1",
                "image": "image",
                "information": "information",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            },
            {
                "id": "1",
                "event_id": "1",
                "image": "image",
                "information": "information",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            }
        ],
        "ticket": {
            "id": "1",
            "event_id": "1",
            "stok": "300",
            "price": "10000",
            "image": "image",
            "payment_method": "bca:number",
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        },
        "feedback": [
            {
                "id": "1",
                "event_id": "1",
                "user_id": "1",
                "comment": "comment",
                "rating": "5",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            },
            {
                "id": "1",
                "event_id": "1",
                "user_id": "1",
                "comment": "comment",
                "rating": "5",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            }
        ],
        "created_at": "2024-10-29T11:01:17.000000Z",
        "updated_at": "2024-10-29T11:01:17.000000Z"
    }
}
```

Response Body Erorr :

```json
{
    "errors": "data event not found"
}
```

## PATCH Event API

Endpoint : PATCH/api/event/:id

Headers :

-   Authorization : token

Request Body :

```json
{
    "user_id": "1",
    "title": "title",
    "deskripsi": "deskripsi",
    "image": "image",
    "status": "ongoing",
    "day": "day",
    "time": "time",
    "duration": "duration",
    "prize": "prize",
    "location": "location",
    "contact": "contact",
    "maps": "maps",
    "event_category_id": "1"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "Success update event",
    "data": {
        "id": "1",
        "user_id": "1",
        "title": "title",
        "deskripsi": "deskripsi",
        "image": "image",
        "status": "ongoing",
        "day": "day",
        "time": "time",
        "duration": "duration",
        "location": "location",
        "contact": "contact",
        "maps": "maps", //optional
        "event_category_id": "1",
        "documentation": [
            {
                "id": "1",
                "event_id": "1",
                "image": "image",
                "information": "information",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            },
            {
                "id": "1",
                "event_id": "1",
                "image": "image",
                "information": "information",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            }
        ],
        "ticket": {
            "id": "1",
            "event_id": "1",
            "stok": "300",
            "price": "10000",
            "image": "image",
            "payment_method": "bca:number",
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        },
        "feedback": [
            {
                "id": "1",
                "event_id": "1",
                "user_id": "1",
                "comment": "comment",
                "rating": "5",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            },
            {
                "id": "1",
                "event_id": "1",
                "user_id": "1",
                "comment": "comment",
                "rating": "5",
                "created_at": "2024-10-29T11:01:17.000000Z",
                "updated_at": "2024-10-29T11:01:17.000000Z"
            }
        ],
        "created_at": "2024-10-29T11:01:17.000000Z",
        "updated_at": "2024-10-29T11:01:17.000000Z"
    }
}
```

Response Body Erorr :

```json
{
    "errors": "data event not found"
}
```

## DELETE Event API

Endpoint : DELETE/api/event/:id

Headers :

-   Authorization : token

Response Body Success :

```json
{
    "status": true,
    "message": "Success delete event",
    "data": {}
}
```

Response Body Erorr :

```json
{
    "errors": "data event not found"
}
```
