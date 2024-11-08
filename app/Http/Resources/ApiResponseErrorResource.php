<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponseErrorResource extends JsonResource
{
    public $message;
    public $httpStatusCode;

    public function __construct($message, $errors = [], $httpStatusCode = 400)
    {
        parent::__construct($errors);
        $this->message = $message;
        $this->httpStatusCode = $httpStatusCode;
    }

    public function toArray(Request $request): array
    {
        return [
            'success' => false,
            'message' => $this->message,
            'errors' => $this->resource ?: [],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpStatusCode);
    }
}
