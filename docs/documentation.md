# Documentation API Spec

## GET Documentation API

Endpoint : GET/api/documentation

Response Body Success :

```json
{
    "status": true,
    "message": "List data documentation",
    "data": [
        {
            "id": "1",
            "event_id": "1",
            "image": "image",
            "information": "information",
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        },
        {
            "id": "2",
            "event_id": "1",
            "image": "image",
            "information": "information",
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

## GET Documentation API

Endpoint : GET/api/documentation/:id

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": {
        "id": "1",
        "event_id": "1",
        "image": "image",
        "information": "information",
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

## POST Documentation API

Endpoint : POST/api/documentation

Headers :

-   Authorization : token

Request Body :

```json
{
    "event_id": "1",
    "image": "image",
    "information": "information"
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
        "image": "image",
        "information": "information",
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

## PATCH Documentation API

Endpoint : PATCH/api/documentation/:id

Headers :

-   Authorization : token

Request Body :

```json
{
    "event_id": "1",
    "image": "image",
    "information": "information"
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
        "image": "image",
        "information": "information",
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

## DELETE Documentation API

Endpoint : DELETE/api/documentation/:id

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
