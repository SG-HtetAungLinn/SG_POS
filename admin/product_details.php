<?php
require "../require/common_function.php";
require '../require/db.php';
require '../require/common.php';

$id     = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) {
    $url = $admin_base_url . "product_list.php?error=ID not found";
    header("Location: $url");
    exit;
}
$sql = "SELECT products.*, categories.name AS category_name, discounts.percent, product_img.image
        FROM `products`
        LEFT JOIN `categories` ON categories.id = products.category_id
        LEFT JOIN `discounts` ON discounts.id = products.discount_id
        LEFT JOIN `product_img` ON product_img.product_id = products.id
        WHERE products.id='$id'";
$res = $mysqli->query($sql);
if ($res->num_rows > 0) {
    $data = [];
    $img = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
        $img[] = $row['image'];
    }

    $data = $data[0];
    if (isset($data['discount_id'])) {
        $discount_price = $data['sale_price'] - (
            ($data['sale_price'] * $data['percent']) / 100);
    }
} else {
    $url = $admin_base_url . "product_list.php?error=ID not found";
    header("Location: $url");
    exit;
}
require './layouts/header.php';
?>
<style>
    .discount_text {
        text-decoration: line-through;
    }
</style>
<div class="content-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>Product Details</h1>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <?php foreach ($img as $item) { ?>
                            <img src="upload/<?= $item ?>" alt="<?= $item ?>" width="300px">
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <small><?= $data['category_name'] ?></small>
                        <h1><?= $data['name'] ?></h1>
                        <p><b>Description: </b><?= $data['description'] ?></p>
                        <p><b>Sale Price: </b><span class="<?= $data['percent'] ? 'discount_text' : ""  ?>"><?= $data['sale_price'] . $money_sign ?></span> <span><?= $discount_price . $money_sign ?></span></p>
                        <p><b>Purchase Price: </b><?= $data['purchase_price'] . $money_sign ?></p>
                        <p><b>Stock Count: </b><?= $data['stock_count'] . $money_sign ?></p>
                        <?php if (isset($data['expire_date']) && $data['expire_date'] !== "0000-00-00") { ?>
                            <p><b>Expire Date: </b><?= $data['expire_date'] . $money_sign ?></p>
                        <?php } ?>
                        <?php if (isset($data['discount_id'])) { ?>
                            <p><b>Discount: </b><?= $data['percent'] ?>% </p>
                        <?php } ?>
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