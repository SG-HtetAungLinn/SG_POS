<?php

if (
    !isset($_SESSION['name'])
    && !isset($_SESSION['email'])
    && !isset($_SESSION['role'])
) {
    $url = $admin_base_url . 'login.php';
    header("Location: $url");
}
