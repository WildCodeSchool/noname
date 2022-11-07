<?php

namespace App\Controller;

use App\Model\CartManager;
use App\Model\ProductManager;

class CartController extends AbstractController
{
    public function index()
    {
        if ($_SESSION["user_id"] === $this->user['id']) {
            $productManager = new ProductManager();
            $products = $productManager->selectProductInCart($this->user['id']);
            return $this->twig->render('Cart/index.html.twig', ['products' => $products]);
        } else {
            header("Location: /");
        }
    }

    public function deleteOneProduct(int $productId)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($productId);
        $productManager->deleteProductInCart($product);
        header("Location: /cart");
    }

    public function valideCart(int $cartId)
    {
        $productManager = new ProductManager();
        $productManager->updateProductsFromCartToSold($cartId);
        $cartManager = new CartManager();
        $cartManager->updateValidateCart($cartId);
        header("Location: /book");
    }
}
