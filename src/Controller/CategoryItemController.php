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
            if ($_POST['type'] === 'add') {
                $_POST['title'] =  ucfirst($_POST['title']);
                $_POST['description'] = ucfirst($_POST['description']);
                // clean $_POST data
                $categoryItem = array_map('trim', $_POST);

                // TODO validations (length, format...)
                $errors = $this->checkdata($categoryItem);


                // if validation is ok, insert and redirection
                if (!empty($errors)) {
                    return $this->twig->render('CategoryItem/index.html.twig', [
                        "errors" => $errors,
                        "categoriesItems" => $categoriesItems
                    ]);
                } else {
                    $categoryItemManager = new CategoryItemManager();
                    $categoryItemManager->insert($categoryItem);
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
        $categoriesItem = $categoryItemManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['title'] =  ucfirst($_POST['title']);
            $_POST['description'] = ucfirst($_POST['description']);
            // clean $_POST data
            $categoryItem = array_map('trim', $_POST);

            // TODO validations (length, format...)
            $errors = $this->checkdata($categoryItem);


            // if validation is ok, insert and redirection
            if (!empty($errors)) {
                return $this->twig->render('CategoryItem/edit.html.twig', [
                    "errors" => $errors,
                    "categoriesItems" => $categoriesItem
                ]);
            } else {
                $categoryItemManager = new CategoryItemManager();
                $categoryItemManager->update($categoryItem);
                header('Location:/categories_items');
                return null;
            }
        }

        return $this->twig->render('CategoryItem/edit.html.twig', [
            "categoriesItem" => $categoriesItem
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
