<?php

namespace App\Postman;

use App\Enums\HttpCode;
use App\Enums\HttpStatus;
use App\Helpers\PostmanHelper;

class PostmanResponseExample
{

    public function __construct(
        protected mixed       $data = null,
        protected HttpCode    $statusCode = HttpCode::OK,
        protected string|null $contentType = 'json',
        protected string|null $name = null,
        protected array|null  $request = null
    )
    {
    }

    public function toArray($request): array
    {
        return [
            'name' => !empty($this->name) ? $this->name : HttpStatus::status($this->statusCode),
            'originalRequest' => !empty($this->request) ? $this->request : $request,
            'status' => HttpStatus::status($this->statusCode),
            'code' => $this->statusCode,
            '_postman_previewlanguage' => !empty($this->contentType) ? $this->contentType : null,
            'header' => null,
            'cookie' => [],
            'responseTime' => null,
            'body' => $this->getBody(),
        ];
    }

    private function getBody(): mixed
    {
        if ($this->statusCode == HttpCode::NO_CONTENT) {
            return null;
        }

        if ($this->contentType == 'json') {
            return json_encode(
                PostmanHelper::response($this->data, $this->statusCode),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );
        }

        return $this->data;
    }
}
