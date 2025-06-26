<?php
require "./require/db.php";
require "./require/common.php";
require "./require/common_function.php";
header('Content-Type: application/json');

$user_id = $_POST['user_id'];
$payment_id = $_POST['payment_id'];

$cart_res = selectData('carts', $mysqli, "WHERE `user_id`=$user_id");
$carts = [];
if ($cart_res->num_rows === 0) {
    while ($row = $cart_res->fetch_assoc()) {
        $data = [
            'user_id'       => $row['user_id'],
            'product_id'    => $row['product_id'],
            'payment_id'    => $payment_id,
            'qty'           => $row['qty']
        ];
        $res =  insertData('orders', $mysqli, $data);
        if ($res) {
            $id = $row["id"];
            deleteData('carts', $mysqli, "`id`='$id'");
        }
    }
    echo json_encode([
        'success' => true,
        'message' => 'Your order success'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'An error occur'
    ]);
}
