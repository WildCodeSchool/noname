<?php

namespace App\Controller;

use App\Model\ProductManager;

class CartController extends AbstractController
{
    public function index(int $cartId)
    {
        $productManager = new ProductManager();
        $products = $productManager->selectProductInCart($cartId);


        return $this->twig->render('Cart/show.html.twig', ['products' => $products]);
    }

    public function deleteOneProduct(int $productId)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($productId);
        $productManager->deleteProductInCart($product);

        var_dump($product);


        // $this->index()
        // return null;
    }
}
