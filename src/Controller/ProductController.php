<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $products = (new ProductManager())->selectPageWithUser();

        return $this->twig->render("Product/index.html.twig", ["products" => $products]);
    }
}
