<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $page = (new ProductManager())->selectPageWithUser($_GET["page"] ?? 1);

        return $this->twig->render("Product/index.html.twig", [
            "products" => $page["products"],
            "currentPage" => $page["currentPage"],
            "pagesCount" => $page["pagesCount"]
        ]);
    }
}
