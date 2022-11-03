<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = "product";

    /**
     * Default amount of products per pages
     */
    public const PER_PAGE = 12;

    /**
     * Return a page of products.
     *
     * ## Return
     *
     * An array containing the representation of a page.
     *
     * ```php
     * [
     * "products" => [], // List of products
     * "currentPage" => 0, // Current page
     * "pagesCount" => 0 // Amount of pages in the database
     * ]
     * ```
     *
     * @param integer $page
     * @param integer $limit
     * @param string $orderBy
     * @param string $direction
     * @return array
     */
    public function selectPageWithUser(
        $page = 1,
        $limit = self::PER_PAGE,
        $orderBy = 'date',
        $direction = "DESC"
    ): array {
        // Get the offset & count pages
        $offset = ($page - 1) * $limit;
        $pagesCount = ceil($this->pdo->query("SELECT COUNT(*) as count FROM product")->fetch()["count"] / $limit);

        // Select products
        $query = "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id";
        if ($orderBy) {
            $query .= " ORDER BY " . $orderBy . " " . $direction;
        }
        $query .= " LIMIT " . $offset . ", " . $limit;

        $products = $this->pdo->query($query)->fetchAll();

        foreach ($products as &$product) {
            $product["photo"] = json_decode($product["photo"], false);
        }

        return [
            "products" => $products,
            "currentPage" => $page,
            "pagesCount" => $pagesCount
        ];
    }

    public function insert(array $product): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`title`, `description`, `material`, `color`, `category_item_id`,
             `category_room`, `condition`, `photo`, `price`)
         VALUES (:title, :description, :material, :color, :category_item_id,
          :category_room, :condition, :photo, :price)");
        $statement->bindValue('title', $product['title'], PDO::PARAM_STR);
        $statement->bindValue(`description`, $product['description'], PDO::PARAM_STR);
        $statement->bindValue(`material`, $product['matter'], PDO::PARAM_STR);
        $statement->bindValue(`color`, $product['palette'], PDO::PARAM_STR);
        $statement->bindValue(`category_item_id`, $product['category'], PDO::PARAM_INT);
        $statement->bindValue(`category_room`, $product['room'], PDO::PARAM_STR);
        $statement->bindValue(`condition`, $product['state'], PDO::PARAM_STR);
        $statement->bindValue(`photo`, $product['file'], PDO::PARAM_STR);
        $statement->bindValue(`price`, $product['price'], PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectlast(int $limit = 1): array
    {
        // Select last products
        $query = "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id ORDER BY p.id DESC";
        if ($limit) {
            $query .= ' LIMIT ' . $limit;
        }

        $products = $this->pdo->query($query)->fetchAll();
        foreach ($products as &$product) {
            $product["photo"] = json_decode($product["photo"], false);
        }

        return $products;
    }
}
