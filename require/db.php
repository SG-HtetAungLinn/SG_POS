<?php
$host = 'localhost';
$username = 'root';
$password = 'password';

$mysqli = new mysqli($host, $username, $password);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
create_database($mysqli);
function create_database($mysqli)
{
    $sql = "CREATE DATABASE IF NOT EXISTS `intern_pos` 
        DEFAULT CHARACTER SET utf8mb4 
        COLLATE utf8mb4_general_ci";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
function select_db($mysqli)
{
    if ($mysqli->select_db("intern_pos")) {
        return true;
    }
    return false;
}
select_db($mysqli);
create_table($mysqli);
function create_table($mysqli)
{
    // users
    $user_sql = "CREATE TABLE IF NOT EXISTS `users`
                (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(200) NOT NULL,
                role ENUM('admin','user') NOT NULL,
                phone VARCHAR(50) NOT NULL,
                gender ENUM('male','female') NOT NULL,
                address TEXT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
                )";
    if ($mysqli->query($user_sql) === false) return false;

    // Category
    $category_sql = "CREATE TABLE IF NOT EXISTS `categories`
                (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
    if ($mysqli->query($category_sql) === false) return false;

    // Discount
    $discount_sql = "CREATE TABLE IF NOT EXISTS `discounts`
                (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                start_date DATE NOT NULL,
                end_date DATE NULL,
                percent VARCHAR(3) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
    if ($mysqli->query($discount_sql) === false) return false;

    // Product
    $product_sql = "CREATE TABLE IF NOT EXISTS `products`
                (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                category_id INT NOT NULL,
                discount_id INT NOT NULL,
                stock_count INT NOT NULL,
                sale_price INT NOT NULL,
                purchase_price INT NOT NULL,
                description TEXT NULL,
                expire_date DATE NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
                FOREIGN KEY (discount_id) REFERENCES discounts(id) ON DELETE CASCADE
                )";
    if ($mysqli->query($product_sql) === false) return false;

    // Product Image
    $product_img_sql = "CREATE TABLE IF NOT EXISTS `product_img`
                (
                id INT AUTO_INCREMENT PRIMARY KEY,
                image VARCHAR(200) NOT NULL,
                product_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
                )";
    if ($mysqli->query($product_img_sql) === false) return false;

    // Cart 
    $cart_sql = "CREATE TABLE IF NOT EXISTS `carts`
                (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                customer_id INT NOT NULL,
                qty INT NOT NULL,
                description TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
                FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
                )";
    if ($mysqli->query($cart_sql) === false) return false;

    // Payment
    $payment_sql = "CREATE TABLE IF NOT EXISTS `payments`
                (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
    if ($mysqli->query($payment_sql) === false) return false;

    // Order
    $order_sql = "CREATE TABLE IF NOT EXISTS `orders`
                (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                customer_id INT NOT NULL,
                payment_id INT NOT NULL,
                qty INT NOT NULL,
                description TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
                FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
                FOREIGN KEY (payment_id) REFERENCES payments(id) ON DELETE CASCADE
                )";
    if ($mysqli->query($order_sql) === false) return false;
}
