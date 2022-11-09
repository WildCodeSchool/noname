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

    private function checkFile(): ?string
    {
        $authorizedExtensions = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 2000000;

        $haveFile = false;
        for ($i = 0; $i < 3; $i++) {
            $extension = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);

            // If the extension is allowed
            if ((in_array($extension, $authorizedExtensions))) {
                $haveFile = true;
            }

            //We check if the image exists and if the weight is authorized in bytes
            if (
                file_exists($_FILES['file']['tmp_name'][$i]) &&
                filesize($_FILES['file']['tmp_name'][$i]) > $maxFileSize
            ) {
                return "Votre fichier doit faire moins de 2M !";
            }
        }

        if (!$haveFile) {
            return 'Tu dois sélectionner une image de type Jpg, Jpeg ou Png !';
        }

        return null;
    }
    // check if a value of key is empty
    private function checkArrayValue(string $key): ?string
    {
        $errors = null;
        if (empty($_POST[$key])) {
            $errors = "Tu dois séléctionner une icône !";
        }

        return $errors;
    }


    private function checkLenghtValue(string $key): ?string
    {
        $errors = null;
        if (strlen($_POST[$key]) < 2 || htmlentities(trim($_POST[$key])) === "") {
            $errors = "Le champ doit comporter 2 caractères minimum!";
        }
        return $errors;
    }

    private function hasFormErrors(array $errors): bool
    {
        foreach ($errors as $error) {
            if (!is_null($error)) {
                return true;
            }
        }
        return false;
    }

    private function processFormErrors(): array
    {
        $errors = [];

        $errors["title"] = $this->checkLenghtValue("title");
        if (strlen($_POST["title"]) > 20) {
            $errors["title"] = "Ton titre est bien trop long (20 caractères max)";
        }

        $errors["description"] = $this->checkLenghtValue("description");
        if (strlen($_POST["description"]) > 255) {
            $errors["description"] = "Ta description est bien trop longue (255 caractères max)";
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

        return $errors;
    }

    public function add(): string
    {
        if (!is_null($this->user)) {
            $errors = [];
            $categories = (new CategoryItemManager())->selectAll();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $uploadDir = 'uploads/';
                $uploadFilePhoto = [];
                foreach ($_FILES["file"]["name"] as $fileName) {
                    if ($fileName != "") {
                        $uploadFilePhoto[] = $uploadDir . basename($fileName);
                    }
                }
                $_POST['title'] =  ucfirst($_POST['title']);

                $product = array_map(function ($parameter) {
                    if (!is_array($parameter)) {
                        $parameter = trim($parameter);
                    }
                    return $parameter;
                }, $_POST);

                $errors = $this->processFormErrors();

                if ($this->hasFormErrors($errors)) {
                    return $this->twig->render("Product/form.html.twig", [
                        "errors" => $errors,
                        "categories" => $categories
                    ]);
                } else {
                    $product['matter'] = json_encode($product['matter']);
                    $product['room'] = json_encode($product['room']);
                    $product['palette'] = json_encode($product['palette']);
                    $product['photo'] = json_encode($uploadFilePhoto);
                    $product["user_id"] = $this->user["id"];

                    foreach ($uploadFilePhoto as $index => $fileName) {
                        move_uploaded_file($_FILES['file']['tmp_name'][$index], $uploadFilePhoto[$index]);
                    }
                    $productManager = new ProductManager();
                    $id = $productManager->insert($product);
                    header("Location:/product?id=" . $id);
                }
            }
            return $this->twig->render("Product/form.html.twig", [
                "categories" => $categories
            ]);
        }
        header("Location:/");
        return "";
    }
    /**
     * Show the products book of the user
     *
     * @return string
     */
    public function book(): string
    {
        if ($this->isConnectedElseRedirection()) {
            $productManager = new ProductManager();
            return $this->twig->render("Product/book.html.twig", $productManager->selectForBook($this->user["id"]));
        }

        return "";
    }

    /**
     * Delete a product on sale
     *
     * @param integer $id
     * @return void
     */
    public function deleteSale(int $id): void
    {
        if ($this->isConnectedElseRedirection()) {
            $productManager = new ProductManager();
            $product = $productManager->selectOneById($id);

            if (isset($product) && ($product["user_id"] === $this->user["id"] || $this->user["isAdmin"] === 1)) {
                $productManager->deleteInSale($product["id"]);
            }

            header("Location: /book");
        }
    }
}
