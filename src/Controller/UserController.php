<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
//---------------Signup---------------------------------------

    //Connection to twig template
public function signup(): string {

    $errors = [];


    if ($_POST) {
    $newUser = new UserManager();

    $newUser->createUser($_POST);
    }

    return $this->twig->render('signup.html.twig', [
        'errors' => $errors
    ]);
}

//create subscribe method, which leads to the form (signup.html)

    //If you have a $_POST

    //if form isn't clean -> send back to the page with errors

    // else use the UserManager with its insert method to prepare query, bind values and execute

    // then you can use a header(location : homepage)

//---------------Connections---------------------------------------
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
