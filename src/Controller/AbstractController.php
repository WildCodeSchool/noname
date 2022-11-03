<?php

namespace App\Controller;

use App\Model\UserManager;
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

        if (isset($_SESSION["user_id"])) {
            $this->user = (new UserManager())->selectOneById($_SESSION["user_id"]);
        }

        // Send the connected global
        $this->twig->addGlobal("user", $this->user);
        $this->twig->addGlobal("requestUri", $_SERVER["REQUEST_URI"]);
        $this->twig->addGlobal("requestParams", $_GET);
    }
}
