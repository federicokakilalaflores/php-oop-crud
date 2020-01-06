<?php
    session_start();
    $page_title = "Edit Product";
    include_once('layouts/header.php');
    include_once('classes/config/Database.php');
    include_once('classes/Product.php');
    include_once('classes/Category.php');

    // get database connection
    $database = new Database();
    $conn = $database->connect();

    // pass connection variable into our objects
    $product = new Product($conn);
    $category = new Category($conn);

    //set the product id and then read
    $product->id =  isset($_GET['id']) ? $_GET['id'] : die("ERROR: ID cannot found!");
    $product->readById();
?>

    <div class="text-right mb-3">  
        <a href="index.php" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Read Products</a>
    </div>
    <?php
        if(isset($_SESSION['error_msg'])){
            echo $_SESSION['error_msg']; 
            unset($_SESSION['error_msg']);
       }
    ?>
    <form action="includes/product/update.php" method="post"> 
        <div class="row">
            <div class="col-sm-6">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name here..."
                    value="<?php echo $product->name ?>">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Enter product price name here..."
                    value="<?php echo $product->price ?>">
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category_id" id="category" class="form-control">
                    <?php
                        foreach($category->read() as $category) :
                        if($product->category_id == $category["id"]) :
                    ?>
                            <option value="<?php echo $category["id"]; ?>" selected><?php echo $category["name"]; ?></option> 
                    <?php else : ?>
                            <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>   
                    <?php
                        endif;
                        endforeach;
                    ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for=description>Description</label>
                    <textarea name="description" id="description" cols="30" rows="7" class="form-control" 
                    placeholder="Enter product description here..." ><?php echo $product->description ?></textarea>
                </div>
            </div>
        </div>
            <button type="submit" class="btn btn-success btn-sm" name="submit"><i class="fa fa-edit"></i> Update Product</button>
    </form>

<?php include_once('layouts/footer.php'); ?>