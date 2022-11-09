<?php

namespace App\Controller;

use App\Model\CategoryItemManager;
use App\Model\UserManager;
use App\Controller\ProductController;
use App\Model\ProductManager;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected array|null $user = null;
    protected array|null $cart = null;



    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => true,
            ]
        );
        $this->twig->addExtension(new DebugExtension());

        // Adding categories for the carousel
        $carouselCategories = (new CategoryItemManager())->selectAllInCarousel();
        $this->twig->addGlobal("carouselCategories", $carouselCategories);

        if (isset($_SESSION["user_id"])) {
            $this->user = (new UserManager())->selectOneById($_SESSION["user_id"]);
            $this->cart = (new ProductManager())->selectProductInCart($_SESSION["user_id"]);
        }

        // Send the connected global
        $this->twig->addGlobal("user", $this->user);
        $this->twig->addGlobal("cart", $this->cart);
        $this->twig->addGlobal("requestUri", $_SERVER["REQUEST_URI"]);
        $this->twig->addGlobal("requestParams", $_GET);
    }

    /**
     * Return if the user is connected and add a `Location` header if not.
     *
     * @param string $redirectionPath
     * @return boolean
     */
    protected function isConnectedElseRedirection(string $redirectionPath = "/"): bool
    {
        $isConnected = !is_null($this->user);
        if (!$isConnected) {
            header("Location: $redirectionPath");
        }
        return $isConnected;
    }
}
