<?php
require "../require/common_function.php";
require '../require/db.php';
require '../require/common.php';
$res = selectData('categories', $mysqli, "", "*", "ORDER BY created_at DESC");
$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('categories', $mysqli, "id=$delete_id");
    if ($res) {
        $url = $admin_base_url . "category_list.php?success=Delete Category Success";
        header("Location: $url");
    }
}
require './layouts/header.php';
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1>Category List</h1>
            <div class="">
                <a href="<?= $admin_base_url . 'category_create.php' ?>" class="btn btn-primary">
                    Create Category
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6">
                <div class="alert alert-success">
                    success
                </div>
            </div>
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="col-2">No.</th>
                                    <th class="col-4">Name</th>
                                    <th class="col-2">Updated At</th>
                                    <th class="col-2">Created At</th>
                                    <th class="col-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= date("Y-m-d g:i:s A", strtotime($row['updated_at'])) ?></td>
                                            <td><?= date("Y-m-d g:i:s A", strtotime($row['created_at'])) ?></td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-primary">Edit</a>
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
            console.log('click');
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
                    window.location.href = 'category_list.php?delete_id=' + id
                }
            });
        })

    })
</script>
<?php
require './layouts/footer.php';
?>