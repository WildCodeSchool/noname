<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(): void
    {
        $loginSuccess = false;

        if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["pseudo"]) {
            $userManager = new UserManager();
            $user = $userManager->selectByPseudo($_POST["pseudo"]);

            if ($user) {
                $_SESSION["user_id"] = $user["id"];
                $loginSuccess = true;
            }
        }

        $redirectUri = $_GET["from"] ? $_GET["from"] : "/";
        if (!$loginSuccess && strpos($redirectUri, "loginFailed") === false) {
            $parameter = strpos($redirectUri, "?") !== false ? "&" : "?";
            $parameter .= "loginFailed=true";
            $redirectUri .= $parameter;
        }
        header("Location: " . $redirectUri);
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: /");
    }
}
