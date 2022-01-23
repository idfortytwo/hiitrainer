<?php

namespace HTTP\Requests;

class Request {
    private string $url;
    private string $method;

    public function __construct(string $url, string $method) {
        $this->url = $url;
        $this->method = $method;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getMethod(): string {
        return $this->method;
    }
}
