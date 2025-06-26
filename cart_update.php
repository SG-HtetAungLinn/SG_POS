<?php
require "./require/db.php";
require "./require/common.php";
require "./require/common_function.php";
header('Content-Type: application/json');
$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];
$qty = $_POST['qty'];

if ($user_id && $product_id && isset($qty)) {
    if ($qty > 0) {
        $data = [
            'qty' => $qty
        ];
        $where = [
            'user_id' => $user_id,
            'product_id' => $product_id
        ];
        $update_res = updateData('carts', $mysqli, $data, $where);
        if ($update_res) {
            echo json_encode([
                'success' => true,
                'message' => 'Cart update success'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'An error occur'
            ]);
        }
    } else {
        $where = "`user_id`='$user_id' AND `product_id`='$product_id'";
        $delete_res = deleteData('carts', $mysqli, $where);
        if ($delete_res) {
            echo json_encode([
                'success' => true,
                'message' => 'Cart delete success'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'An error occur'
            ]);
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Missing parameter'
    ]);
}
