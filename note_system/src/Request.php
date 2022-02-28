<?php

declare(strict_types=1);

namespace Note;

class Request
{
    private array $getRequest = [];
    private array $postRequest = [];

    public function __construct(array $getRequest, array $postRequest)
    {
        $this->getRequest = $getRequest;
        $this->postRequest = $postRequest;
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