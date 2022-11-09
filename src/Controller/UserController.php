<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
//---------------Signup---------------------------------------

    //Connection to twig template
    public function signUp(): ?string
    {
        if (is_null($this->user)) {
            $errors = [];

            $user = $_POST;
            $userManager = new UserManager();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Photo uploading
                $uploadDir = 'uploads/';
                $uploadFilePhoto = $uploadDir . basename($_FILES['photo']['name']);
                $user['photo'] = $uploadFilePhoto;
                move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilePhoto);
            //Making sure certain fields start with capital letter
                $user['firstname'] =  ucfirst($user['firstname']);
                $user['lastname'] = ucfirst($user['lastname']);
            //Cleaning $_POST data
                $user  = array_map('trim', $user);

                $errors = $this->verifyData($user);

                if (!empty($errors)) {
                    return $this->twig->render('signup.html.twig', [
                    "errors" => $errors,
                    ]);
                }

                $userId = $userManager->createUser($user);
                $_SESSION["user_id"] = $userId;
                header("Location: /");
            }

            return $this->twig->render('signup.html.twig', [
            'errors' => $errors
            ]);
        }

        header("Location: /");
        return null;
    }

    private function verifyData($user): array
    {
        $errors = [];

        foreach ($user as $key => $value) {
            if (!isset($value) || htmlentities($value) === '') {
                $errors[$key] = $key . " est obligatoire et dois être valide. ";
            }
        } if (strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20) {
            $errors['pseudo'] = "Le titre doit comporter un minimum de 4 caractères et ne pas dépasser 20 caractères";
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] =
            "L'email doit être valide";
        }

        return $errors;
    }

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
