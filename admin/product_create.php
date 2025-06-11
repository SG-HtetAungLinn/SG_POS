<?php
require '../require/db.php';
require '../require/common.php';
require '../require/common_function.php';
$error = false;
$error_message =
    $name_error =
    $name =
    $description_error =
    $description =
    $category_error =
    $category =
    $discount_error =
    $discount =
    $stock_count_error =
    $stock_count =
    $sale_price_error =
    $sale_price =
    $purchase_price_error =
    $purchase_price =
    $expire_date_error =
    $expire_date =  '';
$category_res = selectData('categories', $mysqli);
$discount_res = selectData('discounts', $mysqli);
if (isset($_POST['form_sub']) && $_POST['form_sub'] == '1') {
    $name           = $mysqli->real_escape_string($_POST['name']);
    $description    = $mysqli->real_escape_string($_POST['description']);
    $category       = $mysqli->real_escape_string($_POST['category']);
    $discount       = $mysqli->real_escape_string($_POST['discount']);
    $stock_count    = $mysqli->real_escape_string($_POST['stock_count']);
    $sale_price     = $mysqli->real_escape_string($_POST['sale_price']);
    $purchase_price = $mysqli->real_escape_string($_POST['purchase_price']);
    $expire_date    = $mysqli->real_escape_string($_POST['expire_date']);
    // For Name
    if ($name === '' || strlen($name) === 0) {
        $error = true;
        $name_error = "Please Fill Product Name.";
    } else if (strlen($name) < 3) {
        $error = true;
        $name_error = "Product name must be fill greater then 3.";
    } else if (strlen($name) > 100) {
        $error = true;
        $name_error = "Product name must be fill less then 100.";
    }
    // For description
    if ($description === '' || strlen($description) === 0) {
        $error = true;
        $description_error = 'Please Enter Description';
    } elseif (strlen($description) > 5000) {
        $error = true;
        $description_error = 'Description must be less then 5000.';
    }
    // Category 
    if ($category === '') {
        $error = true;
        $category_error = "Please choose Category";
    }
    // Discount 
    if ($discount !== '' && $discount > 100) {
        $error = true;
        $discount_error = "Discount must be under 100.";
    }
    // Stock Count 
    if ($stock_count === '' || strlen($stock_count) === 0) {
        $error = true;
        $stock_count_error = "Please enter stock count.";
    } elseif (!is_numeric($stock_count)) {
        $error = true;
        $stock_count_error = "Stock count must be number";
    } elseif ($stock_count > 10000) {
        $error = true;
        $stock_count_error = "Stock count must be under 10000";
    }
    // Sale Price
    if ($sale_price === '' || strlen($sale_price) === 0) {
        $error = true;
        $sale_price_error = "Please enter sale price.";
    } else if (!is_numeric($sale_price)) {
        $error = true;
        $sale_price_error = "Sale price must be number";
    } elseif ($sale_price > 1000000) {
        $error = true;
        $sale_price_error = "Sale price must be under 1000000";
    }
    // Purchase Price
    if ($purchase_price === '' || strlen($purchase_price) === 0) {
        $error = true;
        $purchase_price_error = "Please enter Purchase Price.";
    } else if (!is_numeric($purchase_price)) {
        $error = true;
        $purchase_price_error = "Purchase price must be number";
    } elseif ($purchase_price > 1000000) {
        $error = true;
        $purchase_price_error = "Purchase price must be under 1000000";
    }

    if (!$error) {
        $data = [
            'name'              => $name,
            'category_id'       => $category,
            'discount_id '      => $discount,
            'stock_count'       => $stock_count,
            'sale_price'        => $sale_price,
            'purchase_price'    => $purchase_price,
            'description'       => $description,
            'expire_date'       => $expire_date
        ];
        $result = insertData('products', $mysqli, $data);
        if ($result) {
            $url = $admin_base_url . 'product_list.php?success=Register Success';
            header("Location: $url");
            exit;
        } else {
            $error = true;
            $error_message = "Product Create Fail.";
        }
    }
}
require './layouts/header.php';
?>

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>Product Create</h1>
            <div class="">
                <a href="<?= $admin_base_url . 'product_list.php' ?>" class="btn btn-dark">
                    Back
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-md-6 col-sm-10 col-12">
                <?php if ($error && $error_message) { ?>
                    <div class="alert alert-danger">
                        <?= $error_message ?>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-body">
                        <form action="<?= $admin_base_url ?>product_create.php" method="POST">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" placeholder="Enter Product Name" class="form-control" id="name" value="<?= $name ?>" />
                                <?php if ($error && $name_error) { ?>
                                    <span class="text-danger"><?= $name_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" placeholder="Enter Product Description" id="description"></textarea>
                                <?php if ($error && $description_error) { ?>
                                    <span class="text-danger"><?= $description_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Please Choose Category</option>
                                    <?php if ($category_res->num_rows > 0) {
                                        while ($row = $category_res->fetch_assoc()) { ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <?php if ($error && $category_error) { ?>
                                    <span class="text-danger"><?= $category_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="discount" class="form-label">Discount</label>
                                <select name="discount" id="discount" class="form-control">
                                    <option value="">Please Choose Discount</option>
                                    <?php if ($discount_res->num_rows > 0) {
                                        while ($row = $discount_res->fetch_assoc()) { ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['percent'] ?>%</option>
                                    <?php }
                                    } ?>
                                </select>
                                <?php if ($error && $discount_error) { ?>
                                    <span class="text-danger"><?= $discount_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="stock_count" class="form-label">Stock Count</label>
                                <input type="number" name="stock_count" placeholder="Enter Stock Count" class="form-control" id="stock_count" value="<?= $stock_count ?>" />
                                <?php if ($error && $stock_count_error) { ?>
                                    <span class="text-danger"><?= $stock_count_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="sale_price" class="form-label">Sale Price</label>
                                <input type="number" name="sale_price" placeholder="Enter Sale Price" class="form-control" id="sale_price" value="<?= $sale_price ?>" />
                                <?php if ($error && $sale_price_error) { ?>
                                    <span class="text-danger"><?= $sale_price_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="purchase_price" class="form-label">Purchase Price</label>
                                <input type="number" name="purchase_price" placeholder="Enter Purchase Price" class="form-control" id="purchase_price" value="<?= $purchase_price ?>" />
                                <?php if ($error && $purchase_price_error) { ?>
                                    <span class="text-danger"><?= $purchase_price_error ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="expire_date" class="form-label">Expire Date</label>
                                <input type="text" name="expire_date" placeholder="Enter Expire Date" class="form-control" id="expire_date" value="<?= $expire_date ?>" />
                                <?php if ($error && $expire_date_error) { ?>
                                    <span class="text-danger"><?= $expire_date_error ?></span>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="form_sub" value="1" />
                            <button type="submit" class="btn btn-primary w-100">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->

<?php
require './layouts/footer.php';
?>
<script>
    $('#expire_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
</script>