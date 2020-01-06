<?php
    session_start();
    $page_title = "List of Products";
    $page_url = "index.php?";
    include_once("classes/config/Database.php");
    include_once("classes/Product.php"); 
    include_once("classes/Category.php");
    include_once("layouts/header.php");

    $database = new Database();
    $conn = $database->connect();

    $product = new Product($conn);
    $category = new Category($conn);
    $total_row =  $product->countAll(); 

    include_once("classes/config/core.php");

    $products = $product->paginate($page_start_num, $record_per_page);

    include_once("read.php");

    include_once("paging.php");

    include_once("layouts/footer.php");
?> 