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
