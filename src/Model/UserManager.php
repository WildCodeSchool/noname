<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    /**
     * Return the user with the pseudo passed.
     *
     * @param string $pseudo
     * @return array|null
     */
    public function selectByPseudo(string $pseudo): ?array
    {
        $query = "SELECT * FROM user WHERE pseudo LIKE BINARY :pseudo";

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(":pseudo", $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();

        return $user ? $user : null;
    }
}
