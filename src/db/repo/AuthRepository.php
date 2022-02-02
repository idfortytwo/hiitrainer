<?php

namespace DB\Repo;

use PDO;

class AuthRepository extends Repository {
    public function addUser(string $email, string $passwordHash) : int {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        INSERT INTO users (email, pass_hash, type_id)
        VALUES (:email, :pass_hash, (
            SELECT id as type_id
            FROM user_type
            WHERE type = 'user'
        ))
        RETURNING users.id;
        ");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':pass_hash', $passwordHash);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch()['id'];
    }
}
