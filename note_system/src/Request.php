<?php

declare(strict_types=1);

namespace Note;

class Request
{
    private array $getRequest = [];
    private array $postRequest = [];
    private array $serverRequest = [];

    public function __construct(array $getRequest, array $postRequest, array $serverRequest)
    {
        $this->getRequest = $getRequest;
        $this->postRequest = $postRequest;
        $this->serverRequest = $serverRequest;
    }

    public function isPostDataServer(): bool
    {
        return $this->serverRequest['REQUEST_METHOD'] === 'POST';
    }

    public function isGetDataServer(): bool
    {
        return $this->serverRequest['REQUEST_METHOD'] === 'GET';
    }

    public function postData(): bool
    {
        return !empty($this->postRequest);
    }

    public function getRequestParam(string $name, $defaultValue = null)
    {
        return $this->getRequest[$name] ?? $defaultValue;
    }

    public function postRequestParam(string $name, $defaultValue = null)
    {
        return $this->postRequest[$name] ?? $defaultValue;
    }
}