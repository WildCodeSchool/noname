<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    //---------------Signup---------------------------------------

    public function createUser(array $newUser): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " .
        self::TABLE . " (`pseudo`, `adress`, `email`, `firstname`, `lastname`, `phone_number`, `photo`)
                                      VALUES (:pseudo, :adress, :email, :firstname, :lastname, :phone_number, :photo)");
        $statement->bindValue('pseudo', $newUser['pseudo'], PDO::PARAM_STR);
        $statement->bindValue('adress', $newUser['adress'], PDO::PARAM_STR);
        $statement->bindValue('email', $newUser['email'], PDO::PARAM_STR);
        $statement->bindValue('firstname', $newUser['firstname'], PDO::PARAM_STR);
        $statement->bindValue('lastname', $newUser['lastname'], PDO::PARAM_STR);
        $statement->bindValue('phone_number', $newUser['phone_number'], PDO::PARAM_INT);
        $statement->bindValue('photo', "/" . $newUser['photo'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

//---------------Connections---------------------------------------

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
