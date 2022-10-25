<?php

namespace App\Model;

use PDO;

class CategoryItemManager extends AbstractManager
{
    public const TABLE = 'category_item';

    /**
     * Insert new item in database
     */
    public function insert(array $categoryItem): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`, `description`, `photo`, `logo`)
                                      VALUES (:title, :description, :photo, :logo)");
        $statement->bindValue('title', $categoryItem['title'], PDO::PARAM_STR);
        $statement->bindValue('description', $categoryItem['description'], PDO::PARAM_STR);
        $statement->bindValue('photo', $categoryItem['photo'], PDO::PARAM_STR);
        $statement->bindValue('logo', $categoryItem['logo'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
