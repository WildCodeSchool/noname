<?php

namespace App\Controller;

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
        // Get page number from the URL
        $page = $_GET["page"] ?? 1;

        // Get search terms
        $searchTerms = ProductSearchTerms::fromURLParameters();
        $searchTerms->setUsedForURLTemplate(true);

        // Check if its an int superior to 1
        if (filter_var($page, FILTER_VALIDATE_INT) !== false) {
            $page = max(1, $page);
        } else {
            $page = 1;
        }

        // Get the data from the page
        $pageData = (new ProductManager())->selectPageWithUser(
            $searchTerms->getPage(),
            search: $searchTerms->getSearch()
        );

        // If the requested page is superior to the amount of pages,
        // get the last page available.
        if ($page > $pageData["pagesCount"]) {
            $pageData = (new ProductManager())->selectPageWithUser(
                $pageData["pagesCount"],
                search: $searchTerms->getSearch()
            );
        }

        // Render the view
        return $this->twig->render("Product/index.html.twig", [
            "products" => $pageData["products"],
            "currentPage" => $pageData["currentPage"],
            "pagesCount" => $pageData["pagesCount"],
            "pagesURL" => "/products?" . $searchTerms->toURLParameters()
        ]);
    }

    public function show(int $id): string
    {
        $productManager = new productManager();
        $product = $productManager->selectOneById($id);

        $product['photo'] = json_decode($product['photo'], false);

        return $this->twig->render('Product/show.html.twig', ['product' => $product]);
    }
}
