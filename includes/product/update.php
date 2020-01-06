<?php
    session_start();
    if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] === "POST"){
        include_once("../../classes/config/Database.php");
        include_once("../../classes/Product.php");

        // DB connection
        $database = new Database();
        $conn = $database->connect();
        
        // product object
        $product = new Product($conn);

        // set all product properties
        $product->id = $_POST["id"];
        $product->name = $_POST["name"];
        $product->price = $_POST["price"];
        $product->description = $_POST["description"];
        $product->category_id = $_POST["category_id"];

        // success or failed here
        if($product->update()){
            $_SESSION['error_msg'] = '<div class="alert alert-success">Record updated successfully!</div>';
        }else{
            $_SESSION['error_msg'] = '<div class="alert alert-success">Unable to update!</div>';
        }
        header("location: ../../edit_product.php?id=" . $product->id);
    }
?>