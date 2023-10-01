<?php

namespace App\Models;

use App\Database\Database;

class News
{
    private string $tableName = "news";

    public function __construct(
        public ?int $id,
        public string $title,
        public string $description,
        public int $userId,
    ) {
    }

    /**
     * create
     *
     * @param  ?int $id
     * @param  string $title
     * @param  string $description
     * @return News
     */
    public static function create(?int $id, string $title, string $description, int $userId): News
    {
        return new self($id, $title, $description, $userId);
    }

    /**
     * find
     *
     * @param  int $id
     * @return ?News
     */
    public static function find(int $id): ?News
    {
        $query = "SELECT * FROM news WHERE id = :id limit 1;";
        $statement = (new Database())->getConnection()->prepare($query);

        $model = null;
        if ($statement->execute(['id' => $id])) {
            $data = $statement->fetch();
            $model = News::create($data['id'], $data['title'], $data['description'], $data['user_id']);
        }

        return $model;
    }

    /**
     * all
     *
     * @return array
     */
    public static function all(): ?array
    {
        try {
            $query = "SELECT * FROM news";
            $statement = (new Database())->getConnection()->query($query);

            $models = [];

            while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $models[] = News::create($data['id'], $data['title'], $data['description'], $data['user_id']);
            }

            return $models;
        } catch (\PDOException $e) {
            return null;
        }
    }

    /**
     * store
     *
     * @return ?News
     */
    public function store(): ?News
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (title, description, user_id) VALUES (:title, :description, :user_id)";
            $statement = (new Database())->getConnection()->prepare($query);

            $model = null;
            if ($statement->execute([':title' => $this->title, ':description' => $this->description, ':user_id' => $this->userId])) {
                $model = $this;
            }

            return $model;
        } catch (\PDOException $e) {
            return null;
        }
    }

    /**
     * update
     *
     * @param  array $data
     * @return News
     */
    public function update(array $data): ?News
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET title = :title, description = :description, user_id = :user_id WHERE id = :id";
            $statement = (new Database())->getConnection()->prepare($query);

            $model = null;
            if (
                $statement->execute([
                    ':id' => $this->id,
                    ':title' => $data['title'],
                    ':description' => $data['description'],
                    ':user_id' => $data['user_id']
                ])
            ) {
                $model = $this;
            }
            return $model;
        } catch (\PDOException $e) {
            return null;
        }
    }

    /**
     * delete
     *
     * @return bool
     */
    public function delete(): bool
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE id = :id";
            $statement = (new Database())->getConnection()->prepare($query);
            $statement->bindValue(':id', $this->id);

            return $statement->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}
