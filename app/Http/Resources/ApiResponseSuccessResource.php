<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponseSuccessResource extends JsonResource
{
    public $message;
    public $httpStatusCode;

    public function __construct($message, $resource = [], $httpStatusCode = 200)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->httpStatusCode = $httpStatusCode;
    }

    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => $this->message,
            'data' => $this->resource ?: [],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpStatusCode);
    }
}
