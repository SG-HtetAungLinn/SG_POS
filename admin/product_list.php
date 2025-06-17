<?php
require "../require/common_function.php";
require '../require/db.php';
require '../require/common.php';
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
// $res = selectData('products', $mysqli, "", "*", "ORDER BY created_at DESC");

$sql = "SELECT products.*, categories.name AS category_name, discounts.percent
        FROM `products`
        LEFT JOIN `categories` ON categories.id = products.category_id
        LEFT JOIN `discounts` ON discounts.id = products.discount_id
        ";
$res = $mysqli->query($sql);



$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('products', $mysqli, "id=$delete_id");
    if ($res) {
        $url = $admin_base_url . "product_list.php?success=Delete Product Success";
        header("Location: $url");
    }
}
require './layouts/header.php';
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>Product List</h1>
            <div class="">
                <a href="<?= $admin_base_url . 'product_create.php' ?>" class="btn btn-primary">
                    Create Product
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6">
                <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php } ?>
                <?php if ($error !== '') { ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="">No.</th>
                                    <th class="">Name</th>
                                    <th class="">Category</th>
                                    <th class="">Discount</th>
                                    <th class="">Stock Count</th>
                                    <th class="">Sale Price</th>
                                    <th class="">Purchase Price</th>
                                    <th class="">Expire Date</th>
                                    <th class="">Created At</th>
                                    <th class="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['category_name'] ?></td>
                                            <td><?= isset($row['percent']) ? $row['percent'] . '%' : '-' ?></td>
                                            <td><?= $row['stock_count'] ?></td>
                                            <td><?= $row['sale_price'] ?>MMK</td>
                                            <td><?= $row['purchase_price'] ?>MMK</td>
                                            <td><?= $row['expire_date'] !== '0000-00-00' ? $row['expire_date'] : '-' ?></td>
                                            <td><?= date("Y-m-d g:i:s A", strtotime($row['updated_at'])) ?></td>
                                            <td><?= date("Y-m-d g:i:s A", strtotime($row['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= $admin_base_url . 'product_details.php?id=' . $row['id'] ?>" class="btn btn-sm btn-primary">Details</a>
                                                <a href="<?= $admin_base_url . 'product_edit.php?id=' . $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                                <a href="<?= $admin_base_url . 'product_image_update.php?id=' . $row['id'] ?>" class="btn btn-sm btn-primary">Image</a>
                                                <button data-id="<?= $row['id'] ?>" class="btn btn-sm btn-danger delete_btn">Delete</button>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
<script>
    $(document).ready(function() {
        $('.delete_btn').click(function() {
            const id = $(this).data('id')
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'product_list.php?delete_id=' + id
                }
            });
        })
    })
</script>
<?php
require './layouts/footer.php';
?>