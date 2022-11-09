<?php

namespace App\Model;

use PDO;

class CartManager extends AbstractManager
{
    public const TABLE = "cart";

    public function updateValidateCart(int $cartId): bool
    {
        $query = "UPDATE " . self::TABLE . " SET status_validation = TRUE WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $cartId, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function getCartId(int $userId): int
    {
        $query = "SELECT * FROM cart WHERE user_id = :user_id AND status_validation = FALSE";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        $cart = $statement->fetch();

        if ($cart) {
            return $cart["id"];
        } else {
            $query = "INSERT INTO cart (user_id) VALUE (:user_id)";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
            $statement->execute();
            $lastId = (int) $this->pdo->lastInsertId();
            return $lastId;
        }
    }

    public function addProductToCart(int $cartId, int $productId): void
    {
        $query = "UPDATE product SET cart_id = :cartId, `status` = 'en panier' WHERE id = :productId";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('cartId', $cartId, \PDO::PARAM_INT);
        $statement->bindValue('productId', $productId, \PDO::PARAM_INT);
        $statement->execute();
    }
}
