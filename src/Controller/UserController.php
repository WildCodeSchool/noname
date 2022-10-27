<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["pseudo"]) {
            $userManager = new UserManager();
            $user = $userManager->selectByPseudo($_POST["pseudo"]);

            if ($user) {
                $_SESSION["user_id"] = $user["id"];
            }
        }

        $redirectUri = $_GET["from"] ? $_GET["from"] : "/";
        header("Location: " . $redirectUri);
        return "";
    }

    public function logout(): string
    {
        session_destroy();
        header("Location: /");
        return "";
    }
}
