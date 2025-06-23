<?php

require "db.php";
require "common.php";
require "common_function.php";

// Category
$category_data = [
    ['name' => 'Health & Wellness'],
    ['name' => 'Canned Goods'],
    ['name' => 'Appetizers'],
    ['name' => 'Beverages'],
    ['name' => 'Shoe'],
    ['name' => 'Cloth'],
];
foreach ($category_data as $cate) {
    insertData('categories', $mysqli, $cate);
}
// Payment
$payment_data = [
    ['name' => 'KBZ Pay'],
    ['name' => 'CB Pay'],
    ['name' => 'Wave Pay'],
    ['name' => 'AYA Pay'],
    ['name' => 'UAB Pay'],
    ['name' => 'Cash'],
];
foreach ($payment_data as $pay) {
    insertData('payments', $mysqli, $pay);
}
// Discount
$discount_data = [
    [
        'name' => 'Promotion',
        'percent' => '5',
        'start_date' => '2025-06-12',
        'end_date' => '2025-09-12',
    ],
    [
        'name' => 'Rain Season Promotion',
        'percent' => '10',
        'start_date' => '2025-06-12',
        'end_date' => '2025-09-12',
    ],
    [
        'name' => 'Promotion 15%',
        'percent' => '15',
        'start_date' => '2025-06-12',
        'end_date' => '2025-09-12',
    ],

];
foreach ($discount_data as $desc) {
    insertData('discounts', $mysqli, $desc);
}
// User
$user_data = [
    [
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => md5('password'),
        'role' => 'admin',
        'phone' => '0912345645',
        'gender' => 'male',
    ],
    [
        'name' => 'User',
        'email' => 'user@gmail.com',
        'password' => md5('password'),
        'role' => 'user',
        'phone' => '0912345645',
        'gender' => 'male',
    ],
];
foreach ($user_data as $user) {
    insertData('users', $mysqli, $user);
}

echo "success";
