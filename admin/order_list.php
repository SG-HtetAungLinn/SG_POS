<?php
require "../require/common_function.php";
require '../require/db.php';
require '../require/common.php';
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

$sql = "SELECT 
            O.*,
            P.name AS product_name,
            U.name AS user_name,
            PAY.name AS payment_name
        FROM `orders` O
        LEFT JOIN `products` P ON P.id = O.product_id
        LEFT JOIN `users` U ON U.id = O.user_id
        LEFT JOIN `payments` PAY ON PAY.id = O.payment_id
        ORDER BY O.id DESC";
$res = $mysqli->query($sql);
$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('orders', $mysqli, "id=$delete_id");
    if ($res) {
        $url = $admin_base_url . "order_list.php?success=Delete Order Success";
        header("Location: $url");
    }
}
require './layouts/header.php';
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>Order List</h1>
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
                                    <th class="">User Name</th>
                                    <th class="">Product Name</th>
                                    <th class="">Payment</th>
                                    <th class="">Qty</th>
                                    <th class="">Status</th>
                                    <th class="">Updated At</th>
                                    <th class="">Created At</th>
                                    <th>Status</th>
                                    <th class="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['user_name'] ?></td>
                                            <td><?= $row['product_name'] ?></td>
                                            <td><?= $row['payment_name'] ?></td>
                                            <td><?= $row['qty'] ?></td>
                                            <td>
                                                <?php
                                                $class = $row['status'] === 'pending' ? 'bg-info' : ($row['status'] === 'complete' ? 'bg-success' : 'bg-danger');
                                                ?>
                                                <span class="badge <?= $class ?> text-white"><?= $row['status'] ?></span>
                                            </td>
                                            <td><?= date("Y-m-d g:i:s A", strtotime($row['updated_at'])) ?></td>
                                            <td><?= date("Y-m-d g:i:s A", strtotime($row['created_at'])) ?></td>
                                            <td>
                                                <select name="status" class="form-control form-control-sm status" style="height: auto;">
                                                    <option class="text-info" value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option class="text-success" value="complete" <?= $row['status'] === 'complete' ? 'selected' : '' ?>>Complete</option>
                                                    <option class="text-danger" value="reject" <?= $row['status'] === 'reject' ? 'selected' : '' ?>>Reject</option>
                                                </select>
                                                <input type="hidden" name="order_id" id="order_id" value="<?= $row['id'] ?>" />
                                            </td>
                                            <td>
                                                <a href="<?= $admin_base_url . 'payment_edit.php?id=' . $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
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
        $('.status').change(function() {
            let id = $('#order_id').val()
            $.ajax({
                url: "order_status.php",
                type: "POST",
                data: {
                    id,
                    status: $(this).val()
                },
                success: function(res) {
                    if (res.success) {
                        location.reload()
                    }
                }
            })
        })
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
                    window.location.href = 'order_list.php?delete_id=' + id
                }
            });
        })
    })
</script>
<?php
require './layouts/footer.php';
?>