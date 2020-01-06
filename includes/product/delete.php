<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        include('../../classes/config/Database.php');
        include('../../classes/Product.php');

        // DB Connection
        $database = new Database();
        $conn = $database->connect();

        // product object
        $product = new Product($conn);
        $product->id = $_POST["id"];
        $product->readById();

        // success or error
        if($product->delete()){
            if($product->photo !== "noimage.png"){
                unlink("../../uploads/" . $product->photo); 
            }    
            $_SESSION['error_msg'] = '<div class="alert alert-success">Successfully deleted!</div>';
        }else{
            $_SESSION['error_msg'] = '<div class="alert alert-danger">Unable to delete!</div>';
        }
    }