<?php

namespace App\Controller;

//use App\Model\UserManager;

class UserController extends AbstractController {

public function index(): string {

    return $this->twig->render('signup.html.twig');

}

}
