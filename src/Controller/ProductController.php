<?php

namespace App\Controller;

use App\Model\CategoryItemManager;
use App\Model\ProductManager;
use App\Utils\ProductSearchTerms;

class ProductController extends AbstractController
{
    /**
     * The list of products
     *
     * @return string
     */
    public function index(): string
    {
        // Get search terms
        $searchTerms = ProductSearchTerms::fromURLParameters();
        $searchTerms->setUsedForURLTemplate(true);

        // Get the data from the page
        $productManager = new ProductManager();
        $pageData = $productManager->selectPageWithUser($searchTerms);

        // If there is no pages
        if ($pageData["pagesCount"] <= 0) {
            $pageData["products"] = [];
            $pageData["currentPage"] = 0;
            $pageData["pagesCount"] = 0;

            // Else if the requested page is superior to the amount of pages,
            // get the last page available.
        } elseif ($searchTerms->getPage() > $pageData["pagesCount"]) {
            $searchTerms->setPage($pageData["pagesCount"]);
            $pageData = $productManager->selectPageWithUser($searchTerms);
        }

        // Render the view
        return $this->twig->render("Product/index.html.twig", [
            "products" => $pageData["products"],
            "currentPage" => $pageData["currentPage"],
            "pagesCount" => $pageData["pagesCount"],
            "pagesURL" => "/products?" . $searchTerms->toURLParameters(),
            "categories" => (new CategoryItemManager())->selectAll(),
            "searchTerms" => $searchTerms
        ]);
    }

    public function show(int $id): string
    {
        $productManager = new productManager();
        $product = $productManager->selectOneWithCategoryId($id);

        $product['photo'] = json_decode($product['photo'], false);
        $product['color'] = json_decode($product['color'], false);
        $product['material'] = json_decode($product['material'], false);
        $product['category_room'] = json_decode($product['category_room'], false);

        return $this->twig->render('Product/show.html.twig', ['product' => $product]);
    }

    // check if a key of array is empty
    private function checkArray(string $key): void
    {
        if (empty($_POST[$key])) {
            $_POST[$key] = [];
        }
    }

    private function checkFile(string $key): array
    {
        $errors = [];
        $authorizedExtensions = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 2000000;

        foreach (($_FILES[$key]['name']) as $key2 => $value) {
            $value = "";
            $extension = [];
            $extension[$key2] = pathinfo($_FILES[$key]['name'][$key2], PATHINFO_EXTENSION);
            if ((!in_array($extension[$key2], $authorizedExtensions))) {
                $errors[] = 'Séléctionne une image minimum';
            }
            if (file_exists($_FILES[$key]['name'][$key2]) && filesize($_FILES[$key]['name'][$key2]) > $maxFileSize) {
                $errors[] = 'Votre fichier doit faire moins de 2M';
            }
        }

        return $errors;
    }


    // check if a value of key is empty
    private function checkArrayValue(string $key): string
    {
        $errors = "";
        if (empty($_POST[$key])) {
            $errors = "Tu dois séléctionner une icône !";
        }

        return $errors;
    }


    private function checkLenghtValue(string $key): string
    {
        $errors = "";
        if (strlen($_POST[$key]) < 2 || htmlentities(trim($_POST[$key])) === "") {
            $errors = "Le champ doit comporter 2 caractères minimum!";
        }
        return $errors;
    }

    public function add(): ?string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors["title"] = $this->checkLenghtValue("title");
            if (strlen($_POST["title"]) > 20) {
                $errors["title"] = "Ton titre est bien long (20 caractère max)";
            }

            $errors["description"] = $this->checkLenghtValue("description");
            if (strlen($_POST["description"]) > 155) {
                $errors["description"] = "Ton titre est bien long (20 caractère max)";
            }
            if (
                empty($_POST["price"]) ||
                (!filter_var($_POST["price"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]))
            ) {
                $errors["price"] = "Ton objet ne peut pas être gratuit (entre un prix supérieur à 0€)";
            }
            $this->checkArray("matter");
            $this->checkArray("category");
            $this->checkArray("room");
            $this->checkArray("state");
            $this->checkArray("file");
            $this->checkArray("info");
            $errors["matter"] = $this->checkArrayValue("matter");
            $errors["category"] = $this->checkArrayValue("category");
            $errors["room"] = $this->checkArrayValue("room");
            $errors["state"] = $this->checkArrayValue("state");
            $errors["file"] = $this->checkFile("file");
            $errors["info"] = $this->checkArrayValue("info");
        }

        return $this->twig->render("Product/form.html.twig", [
            "errors" => $errors
        ]);
    }
}
