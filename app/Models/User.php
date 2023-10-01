<?php

namespace App\Models;

use App\Database\Database;

class User
{
    public string $tableName = "users";

    public function __construct(
        public ?int $id,
        public string $username,
        public string $password,
    ) {
    }

    public static function create(?int $id, string $username, string $password): User
    {
        return new self($id, $username, $password);
    }

    /**
     * where
     *
     * @param  string $colName
     * @param  string $param
     * @return array
     */
    public static function where(string $colName, string $param): array
    {
        $query = "SELECT * FROM users WHERE $colName = :param;";
        $statement = (new Database())->getConnection()->prepare($query);

        $models = [];
        if ($statement->execute([':param' => $param])) {
            while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $models[] = User::create($data['id'], $data['username'], $data['password']);
            }
        }
        return $models;
    }

    /**
     * find
     *
     * @param  string $username
     * @return ?User
     */
    public static function findByUsername(string $username): ?User
    {
        $query = "SELECT * FROM users WHERE username = :username limit 1;";
        $statement = (new Database())->getConnection()->prepare($query);

        $model = null;
        if ($statement->execute(['username' => $username])) {
            $data = $statement->fetch();
            $model = User::create($data['id'], $data['username'], $data['password']);
        }

        return $model;
    }
}
