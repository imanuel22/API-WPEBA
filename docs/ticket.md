# Ticket API Spec

## Buying Ticket API

Endpoint : POST/api/ticket/buy

Headers :

-   Authorization : token

Request Body :

```json
{
    "user_id": "1",
    "ticket_id": "1",
    "proof_of_payment": "image",
    "status": "prosses"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": {
        "id": "1",
        "user_id": "1",
        "ticket_id": "1",
        "proof_of_payment": "image",
        "status": "prosses",
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

## Verification Ticket API

Endpoint : POST/api/ticket/vetification/:id

Headers :

-   Authorization : token

Request Body :

```json
{
    "status": "success"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": {
        "id": "1",
        "user_id": "1",
        "ticket_id": "1",
        "proof_of_payment": null,
        "status": "success",
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

## GET Ticket API

Endpoint : GET/api/ticket

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": [
        {
            "id": "1",
            "event_id": "1",
            "stok": "300",
            "price": "10000",
            "image": "image",
            "payment_method": "bca:number",
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        },
        {
            "id": "1",
            "event_id": "1",
            "stok": "300",
            "price": "10000",
            "image": "image",
            "payment_method": "bca:number",
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

## GET Ticket API

Endpoint : GET/api/ticket/:id

Response Body Success :

```json
{
    "status": true,
    "message": "List data event",
    "data": {
        "id": "1",
        "event_id": "1",
        "stok": "300",
        "price": "10000",
        "image": "image",
        "payment_method": "bca:number",
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

## POST Ticket API

Endpoint : POST/api/ticket

Headers :

-   Authorization : token

Request Body :

```json
{
    "event_id": "1",
    "stok": "300",
    "price": "10000",
    "image": "image"
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
        "stok": "300",
        "price": "10000",
        "image": "image",
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

## PATCH Ticket API

Endpoint : PATCH/api/ticket/:id

Headers :

-   Authorization : token

Request Body :

```json
{
    "event_id": "1",
    "stok": "300",
    "price": "10000",
    "image": "image"
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
        "stok": "300",
        "price": "10000",
        "image": "image",
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

## DELETE Ticket API

Endpoint : DELETE/api/ticket/:id

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
