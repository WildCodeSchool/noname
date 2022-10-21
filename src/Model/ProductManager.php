<?php

namespace App\Model;

class ProductManager extends AbstractManager
{
    public const TABLE = "product";

    public function selectPageWithUser($page = 1, $limit = 12, $orderBy = 'date', $direction = "DESC"): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT p.*, u.pseudo as user_pseudo, u.photo as user_photo, u.rating as user_rating";
        $query .= " FROM product p JOIN user u ON p.user_id = u.id";
        if ($orderBy) {
            $query .= " ORDER BY " . $orderBy . " " . $direction;
        }
        $query .= " LIMIT " . $offset . ", " . $limit;

        return $this->pdo->query($query)->fetchAll();
    }
}
