<?php

namespace HTTP\Responses;

class JSONResponse extends Response {
    public function __construct(mixed $content, int $code = 200) {
        parent::__construct($content, $code, 'application/json');
    }

    public function getContent(): string|bool {
        return json_encode($this->content);
    }
}
