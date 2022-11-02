<?php

namespace App\Model;

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
     * @param string|null $search
     * @param int|null $categoryId
     * @return array
     */
    public function selectPageWithUser(
        int $page = 1,
        int $limit = self::PER_PAGE,
        string $orderBy = 'date',
        string $direction = "DESC",
        ?string $search = null,
        ?int $categoryId = null
    ): array {
        // Get the offset & count pages
        $offset = ($page - 1) * $limit;
        $pagesCount = $this->countPages($limit, $search, $categoryId);

        // Make the query
        $query = "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id";
        if ($search || $categoryId) {
            $whereClause = [];
            if ($search) {
                $whereClause[] = "(title LIKE :search OR description LIKE :search)";
            }
            if ($categoryId) {
                $whereClause[] = "category_item_id = :category_item_id";
            }
            $query .= " WHERE " . join(" AND ", $whereClause);
        }
        if ($orderBy) {
            $query .= " ORDER BY " . $orderBy . " " . $direction;
        }
        $query .= " LIMIT " . $offset . ", " . $limit;

        // Prepare the query
        $statement = $this->pdo->prepare($query);
        if ($search) {
            $searchPlaceholder = "%" . $search . "%";
            $statement->bindParam(":search", $searchPlaceholder, \PDO::PARAM_STR);
        }
        if ($categoryId) {
            $statement->bindParam(":category_item_id", $categoryId, \PDO::PARAM_INT);
        }
        $statement->execute();
        $products = $statement->fetchAll();

        // Decode JSON
        foreach ($products as &$product) {
            $product["photo"] = json_decode($product["photo"], false);
        }

        return [
            "products" => $products,
            "currentPage" => $page,
            "pagesCount" => $pagesCount
        ];
    }

    /**
     * Count the amount of pages
     *
     * @param integer $limit
     * @param string|null $search
     * @param int|null $categoryId
     * @return integer
     */
    private function countPages(int $limit, ?string $search = null, ?int $categoryId = null): int
    {
        $query = "SELECT COUNT(*) as count FROM product";
        if ($search || $categoryId) {
            $whereClause = [];
            if ($search) {
                $whereClause[] = "(title LIKE :search OR description LIKE :search)";
            }
            if ($categoryId) {
                $whereClause[] = "category_item_id = :category_item_id";
            }
            $query .= " WHERE " . join(" AND ", $whereClause);
        }

        $statement = $this->pdo->prepare($query);
        if ($search) {
            $searchPlaceholder = "%" . $search . "%";
            $statement->bindParam(":search", $searchPlaceholder, \PDO::PARAM_STR);
        }
        if ($categoryId) {
            $statement->bindParam(":category_item_id", $categoryId, \PDO::PARAM_INT);
        }
        $statement->execute();

        return (int) ceil($statement->fetch()["count"] / $limit);
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
