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
}
