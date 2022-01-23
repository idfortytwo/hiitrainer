<?php

namespace HTTP\Responses;

class NotFoundResponse extends Response {
    public function __construct() {
        parent::__construct('Page not found', 404);
    }
}
