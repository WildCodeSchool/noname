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
        foreach ($array as $item) {
            $query = "UPDATE " . self::TABLE . " SET in_carousel = TRUE where id= " . $item['id'];
            $statement = $this->pdo->prepare($query);
            $statement->execute();
        }
    }
}
