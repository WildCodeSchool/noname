<?php

namespace App\Controller;

class FooterController extends AbstractController
{
    public function about(): string
    {
        return $this->twig->render('about.html.twig');
    }

    public function cgv(): string
    {
        return $this->twig->render('cgv.html.twig');
    }
}
