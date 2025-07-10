<?php
require "../require/db.php";
require "../require/common.php";
require "../require/common_function.php";
header('Content-Type: application/json');
$id = isset($_POST['id']) ? $_POST['id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

if ($id && $status) {
    $data = [
        'status' => $status
    ];
    $where = [
        'id' => $id
    ];
    $res = updateData('orders', $mysqli, $data, $where);
    if ($res) {
        echo json_encode([
            'success' => true,
            'message' => "Status Update Success"
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Status Update Fail"
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Parameter is require"
    ]);
}
