<?php

namespace HTTP\Responses;

class Redirect extends Response {
    private string $location;

    public function __construct(string $location) {
        parent::__construct('', 302);
        $this->location = $location;
    }

    protected function setupHeaders() {
        parent::setupHeaders();
        header('Location: '. $this->location);
    }
}
