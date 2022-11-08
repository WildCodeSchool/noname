<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function insert(array $userData): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`pseudo`, `adress`, `email`, `firstname`, `lastname`, `phone_number`, `photo`)
                                      VALUES (:pseudo, :adress, :email, :firstname, :lastname, :phone_number, :photo)");
        $statement->bindValue('pseudo', $userData['pseudo'], PDO::PARAM_STR);
        $statement->bindValue('adress', $userData['adress'], PDO::PARAM_STR);
        $statement->bindValue('email', $userData['email'], PDO::PARAM_STR);
        $statement->bindValue('firstname', $userData['firstname'], PDO::PARAM_STR);
        $statement->bindValue('lastname', $userData['lastname'], PDO::PARAM_STR);
        $statement->bindValue('phone_number', $userData['phone_number'], PDO::PARAM_STR);
        $statement->bindValue('photo', $userData['photo'], PDO::PARAM_STR);

        $statement->execute();

        var_dump($userData);
        exit;
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

