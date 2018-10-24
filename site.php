<?php

use \Hcode\Page;
use \Hcode\Model\Category;
use \Hcode\Model\Product;


//solicitar pagina principal do site
$app->get('/', function () {
    $Product = Product::listAll();

    $page = new Page();

    $page->setTpl("index", [
        "products" => Product::checkList($Product)
    ]);
});

//CATEGORIA STORE
$app->get('/categories/:idcategory', function ($idcategory) {
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

    $category = new Category();

    $category->get((int)$idcategory);

    $panination = $category->getProductsPage($page);

    $pages = [];

    for ($i = 1; $i <= $panination['pages']; $i++) {
        array_push($pages, [
            'link' => '/categories/' . $category->getidcategory() . '?page=' . $i,
            'page' => $i
        ]);
    }

    $page = new Page();
    $page->setTpl("category", [
        "category" => $category->getValues(),
        "products" => $panination["data"],
        'pages' => $pages
    ]);
});

$app->get("/products/:desurl", function($desurl){
    $product = new product();

    $product->getFromURL($desurl);

 

    $page = new Page();

    $page->setTpl("product-detail",[
        "product"=>$product->getValues(),
        "categories"=>$product->getCategories()
    ]);
});
?>