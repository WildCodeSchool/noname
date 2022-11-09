<?php

namespace App\Controller;

use App\Model\CartManager;
use App\Model\ProductManager;

class CartController extends AbstractController
{
    public function index()
    {
        if (!is_null($this->user)) {
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

    public function addProductToCart(int $id): void
    {
        if (!is_null($this->user)) {
            $cartManager = new CartManager();
            $cartId = $cartManager->getCartId($this->user["id"]);
            $cartManager->addProductToCart($cartId, $id);
            header("Location: /cart");
        } else {
            header("Location: /");
        }
    }
}
