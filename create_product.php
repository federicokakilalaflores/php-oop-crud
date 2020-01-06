<?php
    session_start();
    $page_title = "Create Product";
    include_once('layouts/header.php');
    include_once('classes/config/Database.php');
    include_once('classes/Product.php');
    include_once('classes/Category.php');

    // get database connection
    $database = new Database();
    $conn = $database->connect();

    // pass connection variable into our objects
    $category = new Category($conn);
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
    <form action="includes/product/store.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name here...">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Enter product price name here...">
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category_id" id="category" class="form-control">
                        <?php
                            foreach($category->read() as $category) :
                            extract($category);
                        ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option> 
                        <?php
                            endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="photo">Photo</label><br>
                    <input type="file" name="photo" id="photo">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for=description>Description</label>
                    <textarea name="description" id="description" cols="30" rows="7" class="form-control" 
                    placeholder="Enter product description here..."></textarea>
                </div>
            </div>
        </div>
            <button type="submit" class="btn btn-success btn-sm" name="submit"><i class="fa fa-plus"></i> Add Product</button>
    </form>

<?php include_once('layouts/footer.php'); ?>