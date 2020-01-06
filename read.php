<form action="search.php" method="get">
        <div class="input-group col-md-4 p-0 mb-2">
            <input type="text" name="s" id="searchText" class="form-control" placeholder="Type product name or description..."
            value="<?php if(isset($search_text)) echo $search_text; ?>">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="text-right mb-3">   
            <a href="create_product.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Create Product</a>
    </div>
    <?php 
        if(isset($_SESSION['error_msg'])){
             echo $_SESSION['error_msg']; 
             unset($_SESSION['error_msg']);
        }
    ?>
    <div class="table-responsive-md">
         <table class="table table-hover"> 
            <thead>
                <tr class="bg-primary">
                    <th>PRODUCT</th>
                    <th>PRICE</th>
                    <th>CATEGORY</th> 
                    <th>ACTION</th> 
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($products as $product) : 
                    $category->id = $product['category_id'];
                ?>
                    <tr>
                        <td><?php echo $product['name'] ?></td>
                        <td><?php echo $product['price'] ?></td>
                        <td><?php echo $category->readById()['name'] ?></td>
                        <td>
                           <a href="read_product.php?id=<?php echo $product['id'] ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                           <a href="edit_product.php?id=<?php echo $product['id'] ?>" class="btn btn-warning text-white"><i class="fa fa-edit"></i></a>
                           <a href="" data-id="<?php echo $product['id'] ?>" class="btn btn-danger del-btn"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if($total_row == 0) : ?>
            <div class="alert alert-danger text-center">No records found!</div>
        <?php endif; ?>
    </div>
    <hr class="bg-white">