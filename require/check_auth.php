<?php

if (
    !isset($_SESSION['name'])
    && !isset($_SESSION['email'])
    && !isset($_SESSION['role'])
) {
    $url = $admin_base_url . 'logout.php';
    header("Location: $url");
}
