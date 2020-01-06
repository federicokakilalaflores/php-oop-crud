<?php
session_start();
if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] === "POST"){
    include('../../classes/config/Database.php');
    include('../../classes/Product.php');

    // DB Connection
    $database = new Database();
    $conn = $database->connect();

    // product object
    $product = new Product($conn);
    
    // set product property values
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description']; 
    $product->category_id = $_POST['category_id'];
    $product->photo = !empty($_FILES['photo']['name']) ? sha1_file($_FILES['photo']['tmp_name']) . $_FILES['photo']['name'] : 'noimage.png';

    // print_r($_FILES['photo']);

    if( empty($product->uploadPhoto()) ){
        if($product->store()){
            $_SESSION['error_msg'] = '<div class="alert alert-success">Successfully created!</div>';
        }else{
            $_SESSION['error_msg'] = '<div class="alert alert-success">Unable to add!</div>';
        }
        header("location: ../../create_product.php");
    }else{
        echo $product->uploadPhoto();     
    } 
}
