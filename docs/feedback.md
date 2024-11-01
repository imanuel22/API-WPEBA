# Feedback API Spec

## GET Feedback API

Endpoint : GET/api/feedback

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": [
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
            "id": "2",
            "event_id": "1",
            "user_id": "1",
            "comment": "comment",
            "rating": "5",
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

## GET Feedback API

Endpoint : GET/api/feedback/:id

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": {
        "id": "1",
        "event_id": "1",
        "user_id": "1",
        "comment": "comment",
        "rating": "5",
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

## POST Feedback API

Endpoint : POST/api/feedback

Headers :

-   Authorization : token

Request Body :

```json
{
    "event_id": "1",
    "user_id": "1",
    "comment": "comment",
    "rating": "5"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "Success create event",
    "data": {
        "id": "1",
        "event_id": "1",
        "user_id": "1",
        "comment": "comment",
        "rating": "5",
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

## PATCH Feedback API

Endpoint : PATCH/api/feedback/:id

Headers :

-   Authorization : token

Request Body :

```json
{
    "event_id": "1",
    "user_id": "1",
    "comment": "comment",
    "rating": "5"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "Success update event",
    "data": {
        "id": "1",
        "event_id": "1",
        "user_id": "1",
        "comment": "comment",
        "rating": "5",
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

## DELETE Feedback API

Endpoint : DELETE/api/feedback/:id

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
