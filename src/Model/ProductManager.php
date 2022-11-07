<?php

namespace App\Model;

use PDO;
use App\Utils\ProductSearchTerms;

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
     * @param ProductSearchTerms $searchTerms
     * @param integer $limit
     * @param string $orderBy
     * @param string $direction
     * @return array
     */
    public function selectPageWithUser(
        ProductSearchTerms $searchTerms,
        int $limit = self::PER_PAGE,
        string $orderBy = 'date',
        string $direction = "DESC"
    ): array {
        // Get the offset & count pages
        $offset = ($searchTerms->getPage() - 1) * $limit;
        $pagesCount = $this->countPages($searchTerms, $limit);

        // Make the query
        $query = "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id";
        $query .= $searchTerms->toSQLWhereClause();
        if ($orderBy) {
            $query .= " ORDER BY " . $orderBy . " " . $direction;
        }
        $query .= " LIMIT " . $offset . ", " . $limit;

        // Prepare the query
        $statement = $this->pdo->prepare($query);
        $statement = $this->bindSearchTerms($statement, $searchTerms);
        $statement->execute();
        $products = $statement->fetchAll();

        // Decode JSON
        foreach ($products as &$product) {
            $product["photo"] = json_decode($product["photo"], false);
        }

        return [
            "products" => $products,
            "currentPage" => $searchTerms->getPage(),
            "pagesCount" => $pagesCount
        ];
    }

    /**
     * Count the amount of pages
     *
     * @param ProductSearchTerms $searchTerms
     * @param integer $limit
     * @return integer
     */
    private function countPages(ProductSearchTerms $searchTerms, int $limit): int
    {
        $query = "SELECT COUNT(*) as count FROM product";
        $query .= $searchTerms->toSQLWhereClause();

        $statement = $this->pdo->prepare($query);
        $statement = $this->bindSearchTerms($statement, $searchTerms);
        $statement->execute();

        return (int) ceil($statement->fetch()["count"] / $limit);
    }

    /**
     * Bind a `ProductSearchTerms` in a `PDOStatement`.
     *
     * @param \PDOStatement $statement
     * @param ProductSearchTerms $searchTerms
     * @return \PDOStatement
     */
    private function bindSearchTerms(\PDOStatement $statement, ProductSearchTerms $searchTerms): \PDOStatement
    {
        if ($searchTerms->getSearch()) {
            $searchPlaceholder = "%" . $searchTerms->getSearch() . "%";
            $statement->bindParam(":search", $searchPlaceholder, \PDO::PARAM_STR);
        }
        if ($searchTerms->getCategoryId()) {
            $categoryId = $searchTerms->getCategoryId();
            $statement->bindParam(":category_item_id", $categoryId, \PDO::PARAM_INT);
        }
        return $statement;
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

    // functions for cart

    public function selectProductInCart(int $userId): array
    {
        $query = "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM " . self::TABLE . " p JOIN cart c ON p.cart_id = c.id JOIN user u ON p.user_id = u.id
     WHERE c.user_id = $userId AND c.status_validation = False";
        $products = $this->pdo->query($query)->fetchAll();
        foreach ($products as &$product) {
            $product["photo"] = json_decode($product["photo"], false);
        }

        return $products;
    }

    public function deleteProductInCart(array $product): bool
    {
        $query = "UPDATE " . self::TABLE . " SET cart_id = null, status = 'en vente' WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $product['id'], PDO::PARAM_INT);
        return $statement->execute();
    }

    public function selectOneWithCategoryId(int $id): array|false
    {
        $query = "SELECT p.*, ci.title categoryTitle, ci.logo, u.pseudo, u.adress,";
        $query .= " u.email, u.phone_number, u.rating FROM " . static::TABLE;
        $query .= " p JOIN category_item ci ON p.category_item_id";
        $query .= " = ci.id JOIN user u ON p.user_id = u.id WHERE p.id=:id";
        // prepared request
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function updateProductsFromCartToSold(int $cartId): bool
    {
        $query = "UPDATE " . self::TABLE . " SET status = 'vendu' WHERE cart_id = :cart_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('cart_id', $cartId, PDO::PARAM_INT);
        return $statement->execute();
    }
}
