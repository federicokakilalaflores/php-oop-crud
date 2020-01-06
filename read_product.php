<?php  
    $page_title = "Read Product";
    include_once("layouts/header.php");
    include_once("classes/config/Database.php");
    include_once("classes/Product.php");
    include_once("classes/Category.php");

    $database = new Database();
    $conn = $database->connect();

    $product = new Product($conn);
    $category = new Category($conn);  
  
    $product->id =  isset($_GET['id']) ? $_GET['id'] : die("ERROR: ID cannot found!");
    $product->readById();
    $category->id = $product->category_id;

?>
    <div class="text-right mb-3">  
        <a href="index.php" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Read Products</a>
    </div>
    <div class="table-responsive-md">
        <table class="table table-bordered">
            <tr>
                <th class="bg-primary text-center text-uppercase">Product</th>
                <td class="bg-muted"><?php echo $product->name; ?></td>
            </tr>
            <tr>
                <th class="bg-primary text-center text-uppercase">Price</th>
                <td class="bg-muted"><?php echo $product->price; ?></td>
            </tr>
            <tr>
                <th class="bg-primary text-center text-uppercase">Description</th>
                <td class="bg-muted"><?php echo $product->description; ?></td>
            </tr>
            <tr>
                <th class="bg-primary text-center text-uppercase">Category</th>
                <td class="bg-muted"><?php echo $category->readById()['name']; ?></td>
            </tr>
            <tr>
                <th class="bg-primary text-center text-uppercase">Photo</th>
                <td class="bg-muted"><img src="<?php echo 'uploads/' . $product->photo; ?>" alt="product" 
                class="img img-thumbnail" style="width:250px;"></td>
            </tr>
        </table>
    </div>

<?php include_once("layouts/footer.php"); ?>