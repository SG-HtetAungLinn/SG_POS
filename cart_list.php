<?php
session_start();
require "./require/db.php";
require "./require/common.php";
require "./require/common_function.php";

header('Content-Type: application/json');

$user_id = $_SESSION['id'];

$sql = "SELECT 
            carts.qty, 
            carts.description AS cart_description,
            products.*,
            discounts.percent
        FROM `carts`
            JOIN products ON products.id = carts.product_id
            LEFT JOIN discounts ON discounts.id = products.discount_id
        WHERE `user_id`='$user_id'";
$res = $mysqli->query($sql);
$carts = [];
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $carts[] = $row;
    }
    echo json_encode($carts);
} else {
    echo json_encode($carts);
}
