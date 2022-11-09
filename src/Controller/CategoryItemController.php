<?php

namespace App\Controller;

use App\Model\CategoryItemManager;

class CategoryItemController extends AbstractController
{
    public function index(): string|null
    {
        $categoryItemManager = new CategoryItemManager();
        $categoriesItems = $categoryItemManager->selectAll('id');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés
            // (attention ce dossier doit être accessible en écriture)
            $uploadDir = 'uploads/';
            // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client
            //  (mais d'autre stratégies de nommage sont possibles)

            if ($_POST['type'] === 'add') {
                $uploadFilePhoto = $uploadDir . basename($_FILES['photo']['name']);
                $uploadFileLogo = $uploadDir . basename($_FILES['logo']['name']);
                $_POST['title'] =  ucfirst($_POST['title']);
                $_POST['description'] = ucfirst($_POST['description']);
                // clean $_POST data
                $categoryItem = array_map('trim', $_POST);

                // TODO validations (length, format...)
                $errors = $this->checkdata($categoryItem);
                //Add in categoryItem array the entry photo and logo for insertion
                $categoryItem['photo'] = $uploadFilePhoto;
                $categoryItem['logo'] = $uploadFileLogo;

                // if validation is ok, insert and redirection
                if (!empty($errors)) {
                    return $this->twig->render('CategoryItem/index.html.twig', [
                        "errors" => $errors,
                        "categoriesItems" => $categoriesItems
                    ]);
                } else {
                    move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilePhoto);
                    move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFileLogo);
                    $categoryItemManager = new CategoryItemManager();
                    $categoryItemManager->insert($categoryItem);
                    // on déplace les fichiers temporaires vers le nouvel emplacement sur le serveur.
                    header('Location:/categories_items');
                    return null;
                }
            }
            if ($_POST['type'] === 'select') {
                $errors2 = [];

                // Retrieve selected categories
                $categoriesSelect = $this->insertPostCategory();

                // Checked errors
                if (count($categoriesSelect) < 4 || count($categoriesSelect) > 4) {
                    $errors2[] = "Tu as sélectionné " .
                        count($categoriesSelect) .
                        " catégorie(s) tu dois sélectionner 4 catégories";
                }

                // return $errors2;
                if (!empty($errors2)) {
                    return $this->twig->render('CategoryItem/index.html.twig', [
                        "errors2" => $errors2,
                        "categoriesItems" => $categoriesItems
                    ]);
                } else {
                    $categoryItemManager = new CategoryItemManager();
                    $categoryItemManager->updateNotIncarousel();
                    $categoryItemManager->updateIncarousel($categoriesSelect);
                    header('Location:/');
                }
            }
        }
        return $this->twig->render('CategoryItem/index.html.twig', ['categoriesItems' => $categoriesItems]);
    }

    public function edit(int $id): ?string
    {
        $categoryItemManager = new CategoryItemManager();
        $categoryItem = $categoryItemManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = 'uploads/';
            // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client
            // (mais d'autre stratégies de nommage sont possibles)
            $uploadFilePhoto = $uploadDir . basename($_FILES['photo']['name']);
            $uploadFileLogo = $uploadDir . basename($_FILES['logo']['name']);

            $_POST['title'] =  ucfirst($_POST['title']);
            $_POST['description'] = ucfirst($_POST['description']);
            // clean $_POST data
            $categoryItem = array_map('trim', $_POST);

            // TODO validations (length, format...)
            $errors = $this->checkdata($categoryItem);

            //Add in categoryItem array the entry photo, logo and id for insertion
            $categoryItem['photo'] = $uploadFilePhoto;
            $categoryItem['logo'] = $uploadFileLogo;
            $categoryItem['id'] = $_GET['id'];


            // if validation is ok, insert and redirection
            if (!empty($errors)) {
                return $this->twig->render('CategoryItem/edit.html.twig', [
                    "errors" => $errors,
                    "categoryItem" => $categoryItem
                ]);
            } else {
                move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilePhoto);
                move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFileLogo);
                $categoryItemManager = new CategoryItemManager();
                $categoryItemManager->update($categoryItem);
                header('Location:/categories_items');
                return null;
            }
        }

        return $this->twig->render('CategoryItem/edit.html.twig', [
            "categoryItem" => $categoryItem

        ]);
    }

    private function checkdata($data): array
    {
        $errors = [];

        foreach ($data as $key => $value) {
            if (!isset($value) || htmlentities($value) === '') {
                $errors[$key] = $key . " est obligatoire et dois être valide.";
            }
        }
        if (strlen($_POST['title']) < 4 || strlen($_POST['title']) > 20) {
            $errors['title'] .= "Le titre doit comporter un minimum de 4 caractères et ne pas dépasser 20 caractères";
        }
        if (strlen($_POST['description']) < 4 || strlen($_POST['description']) > 100) {
            $errors['description'] .=
                "La description doit comporter un minimum de 4 caractères et ne pas dépasser 100 caractères";
        }

        $errorsfile = $this->checkfile();

        foreach ($errorsfile as $key => $value) {
            $errors[$key] = $value;
        }
        return $errors;
    }

    private function checkfile(): array
    {

        $errors = [];
        // Je récupère l'extension des fichiers
        $extensionPhoto = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $extensionLogo = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        // Les extensions autorisées
        $authorizedExtensions = ['jpg', 'jpeg', 'png'];
        // Le poids max géré par PHP par défaut est de 2M
        $maxFileSize = 2000000;

        /****** Si l'extension photo  est autorisée *************/
        if ((!in_array($extensionPhoto, $authorizedExtensions))) {
            $errors['photo'] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
        }

        /****** On vérifie si l'image photo existe et si le poids est autorisé en octets *************/
        if (file_exists($_FILES['photo']['tmp_name']) && filesize($_FILES['photo']['tmp_name']) > $maxFileSize) {
            $errors['photo'] = "Votre fichier doit faire moins de 2M !";
        }

        /****** Si l'extension photo  est autorisée *************/
        if ((!in_array($extensionLogo, $authorizedExtensions))) {
            $errors['logo'] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
        }

        /****** On vérifie si l'image photo existe et si le poids est autorisé en octets *************/
        if (file_exists($_FILES['logo']['tmp_name']) && filesize($_FILES['logo']['tmp_name']) > $maxFileSize) {
            $errors['logo'] = "Votre fichier doit faire moins de 2M !";
        }

        return $errors;
    }

    private function insertPostCategory(): array
    {
        $categoriesSelect = [];
        $categoryItemManager = new CategoryItemManager();
        $categoriesItems = $categoryItemManager->selectAll('id');
        if (empty($_POST['category'])) {
            $_POST['category'] = [];
        }
        foreach ($_POST['category'] as $title) {
            foreach ($categoriesItems as $categoryItem) {
                if ($title === $categoryItem['title']) {
                    $categoriesSelect[] = $categoryItem;
                };
            };
        };
        return $categoriesSelect;
    }
}
