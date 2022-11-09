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
        $query .= " WHERE";
        $searchTermsClause = $searchTerms->toSQLWhereClause();
        if ($searchTermsClause !== "") {
            $query .= "(" . $searchTermsClause . ") AND";
        }
        $query .= " p.cart_id IS NULL AND p.status LIKE 'en vente'";
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
        $query = "SELECT COUNT(*) as count FROM product p";
        $query .= " WHERE";
        $searchTermsClause = $searchTerms->toSQLWhereClause();
        if ($searchTermsClause !== "") {
            $query .= "(" . $searchTermsClause . ") AND";
        }
        $query .= " p.cart_id IS NULL";

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
        $query .= " FROM product p JOIN user u ON p.user_id = u.id";
        $query .= " WHERE p.status = 'en vente'";
        $query .= " ORDER BY p.id DESC";
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

    public function insert(array $product): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`title`, `description`, `material`, `color`, `category_item_id`,
             `category_room`, `condition`, `photo`, `price`, `user_id`)
         VALUES (:title, :description, :material, :color, :category_item_id,
          :category_room, :condition, :photo, :price, :user_id)");
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], \PDO::PARAM_STR);
        $statement->bindValue('material', $product['matter'], \PDO::PARAM_STR);
        $statement->bindValue('color', $product['palette'], \PDO::PARAM_STR);
        $statement->bindValue('category_item_id', $product['category'], \PDO::PARAM_INT);
        $statement->bindValue('category_room', $product['room'], \PDO::PARAM_STR);
        $statement->bindValue('condition', $product['state'], \PDO::PARAM_STR);
        $statement->bindValue('photo', $product['photo'], \PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $product['user_id'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    /**
     * Select all product for the book
     *
     * @param integer $userId
     * @return array
     */
    public function selectForBook(int $userId): array
    {
        $query = "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id JOIN cart c ON p.cart_id = c.id";
        $query .= " WHERE c.user_id = :userId AND c.status_validation = true";
        $query .= " AND NOW() < DATE_ADD(DATE(c.date), INTERVAL 7 DAY);";

        $query .= "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id";
        $query .= " WHERE u.id = :userId AND p.status = 'en vente';";

        $query .= "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id";
        $query .= " WHERE p.cart_id IS NOT NULL AND u.id = :userId AND p.status = 'en panier';";

        $query .= "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id";
        $query .= " WHERE p.status = 'vendu' AND u.id = :userId;";

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(":userId", $userId, \PDO::PARAM_INT);
        $statement->execute();

        $boughtProducts = $statement->fetchAll();
        $statement->nextRowset();
        $inSaleProducts = $statement->fetchAll();
        $statement->nextRowset();
        $inCartProducts = $statement->fetchAll();
        $statement->nextRowset();
        $soldProducts = $statement->fetchAll();

        foreach ([&$boughtProducts, &$inSaleProducts, &$inCartProducts, &$soldProducts] as &$products) {
            foreach ($products as &$product) {
                $product["photo"] = json_decode($product["photo"]);
            }
        }

        return [
            "boughtProducts" => $boughtProducts,
            "inSaleProducts" => $inSaleProducts,
            "inCartProducts" => $inCartProducts,
            "soldProducts" => $soldProducts
        ];
    }

    /**
     * Delete an article on sale by a user
     *
     * @param integer $id
     * @return void
     */
    public function deleteInSale(int $id): void
    {
        $query = "DELETE FROM product WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(":id", $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function updateProductsFromCartToSold(int $cartId): bool
    {
        $query = "UPDATE " . self::TABLE . " SET status = 'vendu' WHERE cart_id = :cart_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('cart_id', $cartId, PDO::PARAM_INT);
        return $statement->execute();
    }
}
