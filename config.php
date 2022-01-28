<?php

class Config {
    public function getConnectionCredentials(): array {
        return array(
            'USERNAME' => getenv('DB_USER'),
            'PASSWORD' => getenv('DB_PASSWORD'),
            'HOST' => 'db',
            'PORT' => getenv('DB_PORT'),
            'DATABASE' => getenv('DB_NAME')
        );
    }
}
