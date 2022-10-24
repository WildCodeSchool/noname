<?php

namespace App\Controller;


use App\Model\ProductManager;

class HomeController extends AbstractController
{
  /**
   * Display home page
   */
  public function index(): string
  {
    return $this->twig->render('Home/index.html.twig');
  }

  public function last(): string
  {
    $productManager = new ProductManager();
    $products = $productManager->selectlast(3);

    return $this->twig->render('Home/index.html.twig', ['products' => $products]);
  }
}