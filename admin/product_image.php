<?php
require '../require/db.php';
require '../require/common.php';
require '../require/common_function.php';
$error = false;

if (isset($_POST['form_sub']) && $_POST['form_sub'] == '1') {
    $name           = $mysqli->real_escape_string($_POST['name']);


    if (!$error) {
        $data = [
            'name'              => $name,
            'category_id'       => $category,
            'discount_id'       => $discount,
            'stock_count'       => $stock_count,
            'sale_price'        => $sale_price,
            'purchase_price'    => $purchase_price,
            'description'       => $description,
            'expire_date'       => $expire_date
        ];
        $result = insertData('products', $mysqli, $data);
        if ($result) {
            $url = $admin_base_url . 'product_list.php?success=Product Create Success';
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
            <div class="col-md-8 col-sm-10 col-12">
                <?php if ($error && $error_message) { ?>
                    <div class="alert alert-danger">
                        <?= $error_message ?>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-body">
                        <form action="<?= $admin_base_url ?>product_create.php" method="POST" enctype="multipart/form-data">
                            <div class="d-flex flex-wrap my-3 preview_img_container" style="gap: 10px;">

                            </div>
                            <div class="form-group">
                                <input type="file" name="product_img[]" multiple class="form-control" id="product_img">
                            </div>
                            <input type="hidden" name="form_sub" value="1" />
                            <button type="submit" class="btn btn-primary w-100">Save</button>
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
    $('#product_img').change(function() {
        const files = $(this)[0]?.files;
        if (files && files.length > 0) {
            Array.from(files).forEach((item) => {
                const imageUrl = URL.createObjectURL(item);
                const img = `<img src="${imageUrl}" class="preview_img">`
                $('.preview_img_container').append(img);
            });
        }
    });
</script>