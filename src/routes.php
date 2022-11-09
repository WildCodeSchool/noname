<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [

    '' => ['HomeController', 'index',],
    'book' => ['ProductController', 'book'],
    'book/deleteSale' => ['ProductController', 'deleteSale', ['id']],
    'categories_items' => ['CategoryItemController', 'index',],
    'categories_items/add' => ['CategoryItemController', 'add',],
    'categories_items/edit' => ['CategoryItemController', 'edit', ['id']],
    'login' => ['UserController', 'login'],
    'logout' => ['UserController', 'logout'],
    'products' => ['ProductController', 'index'],
    'product' => ['ProductController', 'show', ['id']],
    'user' => ['UserController'],
    'cart' => ['CartController', 'index', ['id']],
    'cart/update' => ['CartController', 'deleteOneProduct', ['id']],
    'cart/valide' => ['CartController', 'valideCart', ['id']],
    'products/add' => ['ProductController', 'add'],
    'cart/add' => ['CartController', 'addProductToCart', ['id']],
    'about' => ['FooterController', 'about'],
    'CGV' => ['FooterController', 'Cgv'],
    'signup' => ['UserController', 'signUp'],
];
