<?php

namespace DB\Models;

use JsonSerializable;

class User implements JsonSerializable {
    private int $id;
    private string $type;
    private string $email;
    private string $password;

    public static function construct(int $id, string $type, string $email, string $password): User {
        $user = new User();

        $user->id = $id;
        $user->type = $type;
        $user->email = $email;
        $user->password = $password;

        return $user;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }


    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    public function __toString(): string {
        return "User($this->id, '$this->type', '$this->email', '$this->email')";
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
