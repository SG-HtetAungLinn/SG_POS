<?php
require "./require/db.php";
require "./require/common.php";
require "./require/common_function.php";
header('Content-Type: application/json');
$product_id     = isset($_POST['product_id']) ? $_POST['product_id'] : '';
$price          = isset($_POST['price']) ? $_POST['price'] : '';
$user_id    = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$qty            = isset($_POST['qty']) ? $_POST['qty'] : '';
if ($product_id && $price && $user_id && $qty) {

    $selectRes = selectData('carts', $mysqli, "WHERE user_id='$user_id' AND product_id=$product_id");
    if ($selectRes->num_rows > 0) {
        $data = $selectRes->fetch_assoc();
        $totalQty =  $data['qty'] + $qty;
        $updateData = [
            'qty' => $totalQty
        ];
        $where = [
            'user_id'       => $user_id,
            'product_id'    => $product_id
        ];
        updateData('carts', $mysqli, $updateData, $where);
    } else {
        $data = [
            'product_id'    => $product_id,
            'user_id'       => $user_id,
            'qty'           => $qty,
        ];
        $cart_res  = insertData('carts', $mysqli, $data);
    }

    echo json_encode(true);
}
