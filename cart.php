<?php
require "./require/db.php";
require "./require/common.php";
require "./require/common_function.php";
$product_id     = isset($_GET['product_id']) ? $_GET['product_id'] : '';
$price          = isset($_GET['price']) ? $_GET['price'] : '';
$customer_id    = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
$qty            = isset($_GET['qty']) ? $_GET['qty'] : '';
if ($product_id && $price && $customer_id && $qty) {
    $data = [
        'product_id'    => $product_id,
        'customer_id'   => $customer_id,
        'qty'           => $qty,
        'description'   => '',
    ];
    $cart_res  = insertData('carts', $mysqli, $data);
    if ($cart_res) {
        $url  = $base_url . "index.php?success=Add Cart Success";
        header("Location: $url");
        exit;
    }
}
