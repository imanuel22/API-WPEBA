<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponseResource extends JsonResource
{
    public $status;
    public $message;
    public $httpStatusCode;
    public $isError;

    public function __construct($status, $message, $resource=[], $httpStatusCode = 200)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
        $this->httpStatusCode = $httpStatusCode;
    }

    public function toArray(Request $request): array
    {
        $response = [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->status ? $this->resource : [],
            'erorr' => $this->status ? [] : $this->resource,
        ];
        return $response;
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpStatusCode);
    }
}