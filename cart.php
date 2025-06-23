<?php
require "./require/db.php";
require "./require/common.php";
require "./require/common_function.php";
header('Content-Type: application/json');
$product_id     = isset($_POST['product_id']) ? $_POST['product_id'] : '';
$price          = isset($_POST['price']) ? $_POST['price'] : '';
$customer_id    = isset($_POST['customer_id']) ? $_POST['customer_id'] : '';
$qty            = isset($_POST['qty']) ? $_POST['qty'] : '';
if ($product_id && $price && $customer_id && $qty) {

    $selectRes = selectData('carts', $mysqli, "WHERE customer_id='$customer_id' AND product_id=$product_id");
    if ($selectRes->num_rows > 0) {
        $data = $selectRes->fetch_assoc();
        $totalQty =  $data['qty'] + $qty;
        $updateData = [
            'qty' => $totalQty
        ];
        $where = [
            'customer_id' => $customer_id,
            'product_id' => $product_id
        ];
        updateData('carts', $mysqli, $updateData, $where);
    } else {
        $data = [
            'product_id'    => $product_id,
            'customer_id'   => $customer_id,
            'qty'           => $qty,
            'description'   => '',
        ];
        $cart_res  = insertData('carts', $mysqli, $data);
    }

    echo json_encode(true);
}
