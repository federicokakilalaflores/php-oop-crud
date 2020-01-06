<?php
    $search_text = isset($_GET['s']) ? $_GET['s'] : '';
    $page_title = "Searching for \"" . $search_text . "\"";
    $page_url = "search.php?s=". $search_text . "&";
    include_once("classes/config/Database.php");  
    include_once("classes/Product.php");
    include_once("classes/Category.php");
    include_once("layouts/header.php");

    $database = new Database();
    $conn = $database->connect();

    $product = new Product($conn);
    $category = new Category($conn); 
    $total_row =  $product->countAllBySearch($search_text); 

    include_once("classes/config/core.php");

    $products = $product->search($search_text, $page_start_num, $record_per_page);

    include_once("read.php");    

    include_once("paging.php");    

    include_once("layouts/footer.php");
?>