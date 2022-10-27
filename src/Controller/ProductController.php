<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    /**
     * The list of products
     *
     * @return string
     */
    public function index(): string
    {
        // Get page number from the URL
        $page = $_GET["page"] ?? 1;

        // Check if its an int superior to 1
        if (filter_var($page, FILTER_VALIDATE_INT) !== false) {
            $page = max(1, $page);
        } else {
            $page = 1;
        }

        // Get the data from the page
        $pageData = (new ProductManager())->selectPageWithUser($page);

        // If the requested page is superior to the amount of pages,
        // get the last page available.
        if ($page > $pageData["pagesCount"]) {
            $pageData = (new ProductManager())->selectPageWithUser($pageData["pagesCount"]);
        }

        // Render the view
        return $this->twig->render("Product/index.html.twig", [
            "products" => $pageData["products"],
            "currentPage" => $pageData["currentPage"],
            "pagesCount" => $pageData["pagesCount"]
        ]);
    }

    public function add(): ?string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($_POST["title"]) || htmlentities(trim($_POST["title"])) === "") {
                $errors["title"] = "Tu as oublié de choisir un titre";
            } elseif (strlen($_POST["title"]) < 2) {
                $errors["title"] = "Ton titre est bien court (2 caractère min)";
            } elseif (strlen($_POST["title"]) > 20) {
                $errors["title"] = "Ton titre est bien long (20 caractère max)";
            }
            if (empty($_POST["description"]) || htmlentities(trim($_POST["description"])) === "") {
                $errors["description"] = "Tu as oublié de décrire ton offre";
            } elseif (strlen($_POST["description"]) < 2) {
                $errors["description"] = "Ta description est bien courte (2 caractère min).";
            } elseif (strlen($_POST["description"]) > 250) {
                $errors["description"] = "Ta description est bien longue (250 caractère max)";
            }
            if (empty($_POST["matter"]) || htmlentities(array_map("trim", $_POST["matter"]) === "")) {
                $errors["matter"] = "Séléctionne au moins une matière";
            }
            if (empty($_POST["palette"]) || htmlentities(trim($_POST["palette"])) === "") {
                $errors["palette"] = "De quelle couleur est ton produit ?";
            }
            if (empty($_POST["category"]) || htmlentities(trim($_POST["category"])) === "") {
                $errors["category"] = "Dans quelle catégorie ajouter ton offre?";
            }
            if (empty($_POST["room"]) || htmlentities(array_map("trim", $_POST["room"]) === "")) {
                $errors["room"] = "Ton offre est idéale pour quelles pièces?";
            }
            if (empty($_POST["state"]) || htmlentities(trim($_POST["state"])) === "") {
                $errors["state"] = "Dans quel état est ton produit?";
            }
            if (empty($_POST["file"]) || htmlentities(trim($_POST["file"])) === "") {
                $errors["file"] = "Tu as oublié d'ajouter des photos (une photo min)";
            }
            if (empty($_POST["info"]) || htmlentities(array_map("trim", $_POST["info"]) === "")) {
                $errors["info"] = "Quels infos souhaites-tu partager?";
            }
            if (empty($_POST["price"]) || (filter_var($_POST["price"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]])) === "") {
                $errors["price"] = "Ton objet ne peut pas être gratuit (entre un prix supérieur à 0€)";
            }
        }


        return $this->twig->render("Product/form.html.twig", [
            "errors" => $errors,
            "post" => $_POST


        ]);
    }
}
