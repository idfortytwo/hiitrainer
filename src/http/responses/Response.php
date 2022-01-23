<?php

namespace HTTP\Responses;

class Response implements IResponse {
    protected int $code;
    protected mixed $content;
    protected string $contentType;

    public function __construct(mixed $content, int $code = 200, string $contentType = 'text/html') {
        $this->content = $content;
        $this->code = $code;
        $this->contentType = $contentType;
    }

    public function send() {
        $this->setupHeaders();
        $this->sendContent();
    }

    protected function setupHeaders() {
        $this->setResponseCode($this->getCode());
        $this->setContentType($this->getContentType());
    }

    protected function setResponseCode(int $code) {
        http_response_code($code);
    }

    protected function setContentType(string $contentType) {
        header("Content-Type: {$contentType}");
    }

    protected function sendContent() {
        echo $this->getContent();
    }

    public function getCode(): int {
        return $this->code;
    }

    public function getContent(): mixed {
        return $this->content;
    }
    public function getContentType(): string {
        return $this->contentType;
    }
}
