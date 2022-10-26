<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\CategoryItemManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectlast(3);
        $categoryItemManager = new CategoryItemManager();
        $categories = $categoryItemManager->selectAllInCarousel();
        return $this->twig->render('Home/index.html.twig', ['products' => $products, 'categories' => $categories]);
    }
}
