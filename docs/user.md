# User API Spec

## Login User API

Endpoint : POST/api/user/login

## Register User API

Endpoint : POST/api/user/register

Request Body :

```json
{
    "name": "admin",
    "email": "admin@gmail.com",
    "password": "admin",
    "role": "admin",
    "profile": "admin.jpg"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "Success create user",
    "data": {
        "id": "1",
        "name": "admin",
        "email": "admin@gmail.com",
        "role": "admin",
        "profile": "admin.jpg",
        "created_at": "2024-10-29T11:01:17.000000Z",
        "updated_at": "2024-10-29T11:01:17.000000Z"
    }
}
```

Response Body Erorr :

```json
{
    "errors": "data user not found"
}
```

## Logout User API

Endpoint : DELETE/api/user/logout

## GET User API

Endpoint : GET/api/user

Response Body Success :

```json
{
    "status": true,
    "message": "List data user",
    "data": [
        {
            "id": "1",
            "name": "admin",
            "email": "admin@gmail.com",
            "role": "admin",
            "profile": "admin.jpg",
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        },
        {
            "id": "2",
            "name": "admin",
            "email": "admin@gmail.com",
            "role": "admin",
            "profile": "admin.jpg",
            "created_at": "2024-10-29T11:01:17.000000Z",
            "updated_at": "2024-10-29T11:01:17.000000Z"
        }
    ]
}
```

Response Body Erorr :

```json
{
    "errors": "data user not found"
}
```

## GET User API

Endpoint : GET/api/user/:id

Response Body Success :

```json
{
    "status": true,
    "message": "List data user",
    "data": {
        "id": "1",
        "name": "admin",
        "email": "admin@gmail.com",
        "role": "admin",
        "profile": "admin.jpg",
        "created_at": "2024-10-29T11:01:17.000000Z",
        "updated_at": "2024-10-29T11:01:17.000000Z"
    }
}
```

Response Body Erorr :

```json
{
    "errors": "data user not found"
}
```

## POST User API

Endpoint : POST/api/user

Headers :

-   Authorization : token

Request Body :

```json
{
    "name": "admin",
    "email": "admin@gmail.com",
    "password": "admin",
    "role": "admin",
    "profile": "admin.jpg"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "Success create user",
    "data": {
        "id": "1",
        "name": "admin",
        "email": "admin@gmail.com",
        "role": "admin",
        "profile": "admin.jpg",
        "created_at": "2024-10-29T11:01:17.000000Z",
        "updated_at": "2024-10-29T11:01:17.000000Z"
    }
}
```

Response Body Erorr :

```json
{
    "errors": "data user not found"
}
```

## PATCH User API

Endpoint : PATCH/api/user/:id

Headers :

-   Authorization : token

Request Body :

```json
{
    "name": "admin",
    "email": "admin@gmail.com",
    "password": "admin",
    "role": "admin",
    "profile": "admin.jpg"
}
```

Response Body Success :

```json
{
    "status": true,
    "message": "Success update user",
    "data": {
        "id": "1",
        "name": "admin",
        "email": "admin@gmail.com",
        "role": "admin",
        "profile": "admin.jpg",
        "created_at": "2024-10-29T11:01:17.000000Z",
        "updated_at": "2024-10-29T11:01:17.000000Z"
    }
}
```

Response Body Erorr :

```json
{
    "errors": "data user not found"
}
```

## DELETE User API

Endpoint : DELETE/api/user/:id

Headers :

-   Authorization : token

Response Body Success :

```json
{
    "status": true,
    "message": "Success delete user",
    "data": {}
}
```

Response Body Erorr :

```json
{
    "errors": "data user not found"
}
```
