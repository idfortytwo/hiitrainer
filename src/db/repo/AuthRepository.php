<?php

namespace DB\Repo;

use DB\Models\User;
use PDO;

class AuthRepository extends Repository {
    public function addUser(string $email, string $passwordHash): User {
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
        $userID = $stmt->fetch()['id'];

        return User::construct($userID, 'user', $email, $passwordHash);
    }

    public function getUser(string $email): User|null {
        $stmt = $this->database->connect();
        $stmt = $stmt->prepare("
        SELECT users.id as id, type, email, pass_hash as password
        FROM users
        JOIN user_type ut on users.type_id = ut.id
        WHERE email = :email;
        ");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $stmt->fetch();

        return User::construct($rs['id'], $rs['type'], $rs['email'], $rs['password']);
    }
}
