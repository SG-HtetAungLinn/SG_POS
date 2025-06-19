<?php
session_start();
require '../require/check_auth.php';
require '../require/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="./plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="./plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="./plugins/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="./plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Daterange picker plugins css -->
    <link href="./plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="./plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <script src="js/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="js/jquery/dist/jquery.min.js"></script>
</head>

<body>
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="index.html">
                    <b class="logo-abbr"><img src="images/logo.png" alt=""> </b>
                    <span class="logo-compact"><img src="./images/logo-compact.png" alt=""></span>
                    <span class="brand-title">
                        <img src="images/logo-text.png" alt="">
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>

                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="images/user/1.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="app-profile.html"><i class="icon-user"></i> <span><?= $_SESSION['name'] ?></span></a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <span class="btn btn-sm btn-primary"><?= $_SESSION['role'] ?></span>
                                            </a>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="<?= $admin_base_url . 'logout.php' ?>"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">

                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-list menu-icon"></i><span class="nav-text">Category</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= $admin_base_url . 'category_list.php' ?>">List</a></li>
                            <li><a href="<?= $admin_base_url . 'category_create.php' ?>">Create</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-wallet menu-icon"></i><span class="nav-text">Payment</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= $admin_base_url . 'payment_list.php' ?>">List</a></li>
                            <li><a href="<?= $admin_base_url . 'payment_create.php' ?>">Create</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-graph menu-icon"></i><span class="nav-text">Discount</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= $admin_base_url . 'discount_list.php' ?>">List</a></li>
                            <li><a href="<?= $admin_base_url . 'discount_create.php' ?>">Create</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Product</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= $admin_base_url . 'product_list.php' ?>">List</a></li>
                            <li><a href="<?= $admin_base_url . 'product_create.php' ?>">Create</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Order</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= $admin_base_url . 'order_list.php' ?>">List</a></li>
                            <li><a href="<?= $admin_base_url . 'order_create.php' ?>">Create</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->