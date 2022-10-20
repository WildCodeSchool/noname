<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\UserManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $products = (new ProductManager())->selectAll('date', 'DESC');

        foreach ($products as &$product) {
            $user = (new UserManager())->selectOneById($product["user_id"]);
            $product["user_pseudo"] = $user["pseudo"];
            $product["user_rating"] = $user["rating"];
        }

        return $this->twig->render("Product/index.html.twig", ["products" => $products]);
    }
}
