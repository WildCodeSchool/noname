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

        return [
            "products" => $this->pdo->query($query)->fetchAll(),
            "currentPage" => $page,
            "pagesCount" => $pagesCount
        ];
    }
}
