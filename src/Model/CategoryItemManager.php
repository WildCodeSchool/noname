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
        $statement->bindValue('photo', "/" . $categoryItem['photo'], PDO::PARAM_STR);
        $statement->bindValue('logo', "/" . $categoryItem['logo'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    // Select all categories in carousel from home page
    public function selectAllInCarousel(): array
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE in_carousel = TRUE";
        $categories = $this->pdo->query($query)->fetchAll();
        return $categories;
    }

    // Clean categories in carousel from home page
    public function updateNotIncarousel(): void
    {
        $query = "UPDATE " . self::TABLE . " SET in_carousel = FALSE";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    // Insert new categories in carousel from home page
    public function updateIncarousel(array $array): void
    {
        $value = [];
        foreach ($array as $item) {
            $value[] = $item['id'];
        }

        $query = "UPDATE " . self::TABLE .
            " SET in_carousel = TRUE WHERE id IN ($value[0], $value[1], $value[2], $value[3])";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function update(array $categoryItem): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE
        . " SET `title` = :title, `description` = :description, `photo` = :photo, `logo` = :logo WHERE id=:id");
        $statement->bindValue('id', $categoryItem['id'], PDO::PARAM_INT);
        $statement->bindValue('title', $categoryItem['title'], PDO::PARAM_STR);
        $statement->bindValue('description', $categoryItem['description'], PDO::PARAM_STR);
        $statement->bindValue('photo', '/' . $categoryItem['photo'], PDO::PARAM_STR);
        $statement->bindValue('logo', '/' . $categoryItem['logo'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
